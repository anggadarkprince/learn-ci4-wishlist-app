<?php

namespace App\Controllers;

use App\Libraries\File;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class Account extends BaseController
{
    public function index()
    {
        $title = 'Account';

        $user = auth();

        return view('account/index', compact('title', 'user'));
    }

    /**
     * Update account data.
     *
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function update()
    {
        $userData = auth();

        $rules = [
            'name' => 'trim|required|max_length[50]',
            'username' => 'required|max_length[50]|is_unique[users.username,id,' . $userData->id . ']',
            'email' => 'required|max_length[50]|is_unique[users.email,id,' . $userData->id . ']',
            'password' => 'required|password_granted',
            'new_password' => 'permit_empty|min_length[6]|max_length[50]',
            'confirm_password' => 'matches[new_password]'
        ];

        if ($this->validate($rules)) {
            $dataAccount = $this->request->getPost(['name', 'username', 'email']);
            $newPassword = $this->request->getPost('new_password');

            $file = $this->request->getFile('avatar');
            if (!empty($file)) {
                $fileName = $file->getRandomName();
                $fileDirectory = 'avatars/' . date('Y/m/');

                $fileHandler = new File();
                $fileHandler->makeFolder('uploads/' . $fileDirectory);

                $filePath = WRITEPATH . 'uploads/' . $fileDirectory;
                if ($file->move($filePath, $fileName)) {
                    if (!empty($userData->avatar)) {
                        $fileHandler->delete('uploads/' . $userData->avatar);
                    }
                } else {
                    return redirect()->back()->withInput()
                        ->with('status', 'warning')
                        ->with('message', $file->getErrorString());
                }

                $dataAccount['avatar'] = $fileDirectory . $fileName;
            }

            if (!empty($newPassword)) {
                $dataAccount['password'] = $newPassword;
            }

            $user = new UserModel();
            $update = $user->set($dataAccount)->update($userData->id);

            if ($update) {
                return redirect()->to('/account')
                    ->with('status', 'success')
                    ->with('message', "Account successfully updated");
            }
        }
        return redirect()->back()->withInput()
            ->with('status', 'danger')
            ->with('message', "Update account failed, try again or contact our support");
    }

}
