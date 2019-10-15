<?php

namespace App\Models;

use Config\Database;
use Exception;
use stdClass;

class UserSettingModel extends BaseModel
{
    protected $table = 'user_settings';
    protected $returnType = 'object';

    protected $allowedFields = ['user_id', 'setting_id', 'value'];

    /**
     * Filter data by conditions.
     *
     * @param $key
     * @param string $default
     * @return string
     * @throws Exception
     */
    public static function getSetting($key = null, $default = '')
    {
        $settings = Database::connect()
            ->table('user_settings')
            ->select([
                'settings.id',
                'settings.setting',
                'settings.description',
                'settings.type',
                'settings.default',
                'user_settings.value'
            ])
            ->join('settings', 'settings.id = user_settings.setting_id', 'right')
            ->where('user_id', auth('id'))
            ->get()
            ->getResult();

        $dataSettings = new stdClass();
        foreach ($settings as $data) {
            $settingValue = new stdClass();
            $settingValue->id = $data->id;
            $settingValue->value = (is_null($data->value) || $data->value == '') ? $data->default : $data->value;
            $settingValue->type = $data->type;
            $settingValue->default = $data->default;
            $settingValue->description = $data->description;

            $dataSettings->{$data->setting} = $settingValue;
        }

        // get specific setting value
        if (property_exists($dataSettings, $key)) {
            $value = $dataSettings->$key->value;
            if (is_null($value) || $dataSettings->$key->value == '') {
                // if default access value not specify then return default setting
                if (!empty($default)) {
                    return $default;
                }
                return $dataSettings->$key->default;
            }
            return $value;
        }

        // if setting key not set then return whole setting data
        if (is_null($key)) {
            return $dataSettings;
        }

        throw new Exception('No setting key ' . $key . ' available');
    }
}
