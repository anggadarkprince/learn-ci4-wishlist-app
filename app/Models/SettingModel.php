<?php

namespace App\Models;

class SettingModel extends BaseModel
{
    protected $table = 'settings';
    protected $returnType = 'object';

    const SETTINGS = [
        SETTING_NOTIFICATION_NEWS_UPDATE,
        SETTING_NOTIFICATION_LOGIN_DEVICE,
        SETTING_NOTIFICATION_WISHLIST_PROGRESS,
        SETTING_NOTIFICATION_PARTICIPANT_WISHLIST,
        SETTING_PRIVACY_ALLOW_DISCOVERY,
        SETTING_PRIVACY_AUTO_PARTICIPANT,
    ];
}
