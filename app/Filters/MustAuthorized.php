<?php

namespace App\Filters;

use App\Models\AuthModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MustAuthorized implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $rules = [
            'master' => [
                'roles' => [
                    '' => PERMISSION_ROLE_VIEW,
                    'index' => PERMISSION_ROLE_VIEW,
                    'view' => PERMISSION_ROLE_VIEW,
                    'new' => PERMISSION_ROLE_CREATE,
                    'create' => PERMISSION_ROLE_CREATE,
                    'edit' => PERMISSION_ROLE_EDIT,
                    'update' => PERMISSION_ROLE_EDIT,
                    'delete' => PERMISSION_ROLE_DELETE,
                ],
                'users' => [
                    '' => PERMISSION_USER_VIEW,
                    'index' => PERMISSION_USER_VIEW,
                    'view' => PERMISSION_USER_VIEW,
                    'new' => PERMISSION_USER_CREATE,
                    'create' => PERMISSION_USER_CREATE,
                    'edit' => PERMISSION_USER_EDIT,
                    'update' => PERMISSION_USER_EDIT,
                    'delete' => PERMISSION_USER_DELETE,
                ]
            ],
            'wishlists' => [
                '' => PERMISSION_WISHLIST_VIEW,
                'index' => PERMISSION_WISHLIST_VIEW,
                'view' => PERMISSION_WISHLIST_VIEW,
                'new' => PERMISSION_WISHLIST_CREATE,
                'create' => PERMISSION_WISHLIST_CREATE,
                'edit' => PERMISSION_WISHLIST_EDIT,
                'update' => PERMISSION_WISHLIST_EDIT,
                'delete' => PERMISSION_WISHLIST_DELETE,
            ],
            'account' => [
                '' => PERMISSION_ACCOUNT_EDIT,
                'index' => PERMISSION_ACCOUNT_EDIT,
                'update' => PERMISSION_ACCOUNT_EDIT,
            ],
            'setting' => [
                '' => PERMISSION_SETTING_EDIT,
                'index' => PERMISSION_SETTING_EDIT,
                'update' => PERMISSION_SETTING_EDIT,
            ],
            'backup' => [
                '' => PERMISSION_UTILITY_EDIT,
                'index' => PERMISSION_UTILITY_EDIT,
                'database' => PERMISSION_UTILITY_EDIT,
                'upload' => PERMISSION_UTILITY_EDIT,
            ],
            'logs' => [
                '' => PERMISSION_UTILITY_EDIT,
                'index' => PERMISSION_UTILITY_EDIT,
                'system' => PERMISSION_UTILITY_EDIT,
                'access' => PERMISSION_UTILITY_EDIT,
                'view' => PERMISSION_UTILITY_EDIT,
            ],
        ];

        helper(['value', 'array']);
        $segments = $request->uri->getSegments();
        $permission = dot_array_search(implode('.', $segments), $rules);
        if(is_array($permission)) {
            $permission = $permission[''];
        }

        if (!AuthModel::isAuthorized($permission)) {
            $agent = $request->getUserAgent();
            return redirect()->to(if_empty($agent->getReferrer(), '/'))
                ->with('status', 'danger')
                ->with('message', 'You are unauthorized to perform this action.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
