<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            PERMISSION_ALL_ACCESS => [
                'module' => 'admin',
                'submodule' => 'admin',
                'description' => 'All admin access',
            ],
            PERMISSION_ACCOUNT_EDIT => [
                'module' => 'setting',
                'submodule' => 'account',
                'description' => 'Update account setting'
            ],
            PERMISSION_SETTING_EDIT => [
                'module' => 'setting',
                'submodule' => 'setting',
                'description' => 'Update application setting'
            ],

            PERMISSION_ROLE_VIEW => [
                'module' => 'master',
                'submodule' => 'role',
                'description' => 'View available role'
            ],
            PERMISSION_ROLE_CREATE => [
                'module' => 'master',
                'submodule' => 'role',
                'description' => 'Create new role'
            ],
            PERMISSION_ROLE_EDIT => [
                'module' => 'master',
                'submodule' => 'role',
                'description' => 'Edit role permission'
            ],
            PERMISSION_ROLE_DELETE => [
                'module' => 'master',
                'submodule' => 'role',
                'description' => 'Delete existing role'
            ],

            PERMISSION_USER_VIEW => [
                'module' => 'master',
                'submodule' => 'user',
                'description' => 'View registered user'
            ],
            PERMISSION_USER_CREATE => [
                'module' => 'master',
                'submodule' => 'user',
                'description' => 'Create new user'
            ],
            PERMISSION_USER_EDIT => [
                'module' => 'master',
                'submodule' => 'user',
                'description' => 'Edit user data'
            ],
            PERMISSION_USER_DELETE => [
                'module' => 'master',
                'submodule' => 'user',
                'description' => 'Delete existing user'
            ],

            PERMISSION_WISHLIST_VIEW => [
                'module' => 'wishlist',
                'submodule' => 'wishlist',
                'description' => 'View wish list'
            ],
            PERMISSION_WISHLIST_CREATE => [
                'module' => 'wishlist',
                'submodule' => 'wishlist',
                'description' => 'Create new wish list'
            ],
            PERMISSION_WISHLIST_EDIT => [
                'module' => 'wishlist',
                'submodule' => 'wishlist',
                'description' => 'Edit existing wish list'
            ],
            PERMISSION_WISHLIST_DELETE => [
                'module' => 'wishlist',
                'submodule' => 'wishlist',
                'description' => 'Delete existing wish list'
            ],
            PERMISSION_WISHLIST_MANAGE => [
                'module' => 'wishlist',
                'submodule' => 'wishlist',
                'description' => 'Manage all data of wish list'
            ],
        ];

        $this->db->transStart();
        
        foreach ($permissions as $permission => $detail) {
            $isPermissionExist = $this->db->table('permissions')
                ->where('permission', $permission)
                ->countAllResults();

            if (!$isPermissionExist) {
                $this->db->table('permissions')->insert([
                    'permission' => $permission,
                    'module' => $detail['module'],
                    'submodule' => $detail['submodule'],
                    'description' => $detail['description'],
                ]);
            }
        }

        $this->db->transComplete();
    }
}
