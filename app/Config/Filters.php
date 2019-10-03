<?php namespace Config;

use App\Filters\MustAuthenticated;
use App\Filters\MustAuthorized;
use App\Filters\RedirectIfAuthenticated;
use App\Filters\Logger;
use App\Filters\Throttle;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
    // Makes reading things below nicer,
    // and simpler to change out script that's used.
    public $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'auth' => MustAuthenticated::class,
        'authorized' => MustAuthorized::class,
        'guest' => RedirectIfAuthenticated::class,
        'logger' => Logger::class,
        'throttle' => Throttle::class
    ];

    // Always applied before every request
    public $globals = [
        'before' => [
            'honeypot',
            'csrf',
        ],
        'after' => [
            'logger',
            'toolbar',
            //'honeypot'
        ],
    ];

    // Works on all of a particular HTTP method
    // (GET, POST, etc) as BEFORE filters only
    //     like: 'post' => ['CSRF', 'throttle'],
    public $methods = [
        'post' => ['throttle']
    ];

    // List filter aliases and any before/after uri patterns
    // that they should run on, like:
    //    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
    public $filters = [
        'authorized' => [
            'before' => [
                'master/roles*',
                'master/users*',
                'wishlists*',
                'account*',
                'setting*',
                'backup*',
                'logs*'
            ]
        ],
    ];
}
