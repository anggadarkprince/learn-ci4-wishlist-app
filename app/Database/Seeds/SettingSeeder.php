<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            SETTING_NOTIFICATION_NEWS_UPDATE => [
                'type' => 'notification',
                'default' => 0,
                'description' => 'Let me know about wishlist application news & updated'
            ],
            SETTING_NOTIFICATION_LOGIN_DEVICE => [
                'type' => 'notification',
                'default' => 0,
                'description' => 'Give me detail info every login device'
            ],
            SETTING_NOTIFICATION_WISHLIST_PROGRESS => [
                'type' => 'notification',
                'default' => 1,
                'description' => 'Send push and email when your wishlist updated'
            ],
            SETTING_NOTIFICATION_PARTICIPANT_WISHLIST => [
                'type' => 'notification',
                'default' => 1,
                'description' => 'Send push and email when other update their wishlist'
            ],

            SETTING_PRIVACY_ALLOW_DISCOVERY => [
                'type' => 'privacy',
                'default' => 1,
                'description' => 'Hide account from discovery'
            ],
            SETTING_PRIVACY_AUTO_PARTICIPANT => [
                'type' => 'privacy',
                'default' => 0,
                'description' => 'Auto confirm participant wishlist request'
            ],
        ];

        $this->db->transStart();
        
        foreach ($settings as $setting => $detail) {
            $isPermissionExist = $this->db->table('permissions')
                ->where('permission', $setting)
                ->countAllResults();

            if (!$isPermissionExist) {
                $this->db->table('settings')->insert([
                    'setting' => $setting,
                    'type' => $detail['type'],
                    'default' => $detail['default'],
                    'description' => $detail['description'],
                ]);
            }
        }

        $this->db->transComplete();
    }
}
