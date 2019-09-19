<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Social extends BaseConfig
{
    public $driver = [
        'github' => [
            'client_id' => '50f51e78756240877e14',
            'client_secret' => 'c6364a1a55e2924e0047959e98d7aa774008d1ac',
            'redirect' => 'http://localhost:8080/login/github/callback',
        ],
        'google' => [
            'client_id' => '572833561614-qhune1ar4cfgpd386irqhkaulh52cfhh.apps.googleusercontent.com',
            'client_secret' => 'D472HGli9JGUIieImiOzwV-p',
            'redirect' => 'http://localhost:8080/login/google/callback',
        ],
    ];
}