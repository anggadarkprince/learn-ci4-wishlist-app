<?php

namespace App\Controllers;

use App\Libraries\File;
use App\Models\SettingModel;
use App\Models\UserModel;
use App\Models\UserSettingModel;
use CodeIgniter\HTTP\RedirectResponse;
use Exception;
use ReflectionException;

class Setting extends BaseController
{
    /**
     * @return string
     * @throws Exception
     */
    public function index()
    {
        $title = 'Settings';

        $settings = UserSettingModel::getSetting();

        return view('setting/index', compact('title', 'settings'));
    }

    /**
     * Update account data.
     *
     * @return RedirectResponse
     * @throws ReflectionException
     * @throws Exception
     */
    public function update()
    {
        $this->db->transStart();

        $userId = auth('id');
        foreach (SettingModel::SETTINGS as $key) {
            $userSetting = new UserSettingModel();
            $settingId = UserSettingModel::getSetting()->$key->id;
            $setting = $userSetting
                ->where('user_id', $userId)
                ->where('setting_id', $settingId)
                ->get()
                ->getRowArray();

            if (empty($setting)) {
                $setting = [
                    'user_id' => $userId,
                    'setting_id' => $settingId,
                ];
            }
            $setting['value'] = if_empty($this->request->getPost($key), 0);
            $userSetting->save($setting);
        }

        $this->db->transComplete();

        if ($this->db->transStatus()) {
            return redirect()->to('/setting')
                ->with('status', 'success')
                ->with('message', "Setting successfully updated");
        }
        return redirect()->back()->withInput()
            ->with('status', 'danger')
            ->with('message', "Update setting failed, try again or contact our support");
    }

}
