<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            PERMISSION_ALL_ACCESS => 'All admin access',
            PERMISSION_ACCOUNT_EDIT => 'Update account setting',
            PERMISSION_SETTING_EDIT => 'Update application setting',

            PERMISSION_ROLE_VIEW => 'View available role',
            PERMISSION_ROLE_CREATE => 'Create new role',
            PERMISSION_ROLE_EDIT => 'Edit role permission',
            PERMISSION_ROLE_DELETE => 'Delete existing role',

            PERMISSION_USER_VIEW => 'View registered user',
            PERMISSION_USER_CREATE => 'Create new user',
            PERMISSION_USER_EDIT => 'Edit user data',
            PERMISSION_USER_DELETE => 'Delete existing user',

            PERMISSION_WISHLIST_VIEW => 'View wish list',
            PERMISSION_WISHLIST_CREATE => 'Create new wish list',
            PERMISSION_WISHLIST_EDIT => 'Edit existing wish list',
            PERMISSION_WISHLIST_DELETE => 'Delete existing wish list',
            PERMISSION_WISHLIST_MANAGE => 'Manage all data of wish list',
        ];

        $this->db->transStart();
        
        foreach ($permissions as $permission => $description) {
            $isPermissionExist = $this->db->table('permissions')
                ->where('permission', $permission)
                ->countAllResults();

            if (!$isPermissionExist) {
                $this->db->table('permissions')->insert([
                    'permission' => $permission,
                    'description' => $description
                ]);
            }
        }

        $this->db->transComplete();
    }
}
