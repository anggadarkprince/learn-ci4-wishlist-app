<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ROLE_RESERVED_ADMIN => 'Administrator role access',
            ROLE_RESERVED_USER => 'Regular user role access',
        ];

        $this->db->transStart();

        foreach ($roles as $role => $description) {
            $isRoleExist = $this->db->table('roles')
                ->where('role', $role)
                ->countAllResults();

            if (!$isRoleExist) {
                $this->db->table('roles')->insert([
                    'role' => $role,
                    'description' => $description
                ]);

                if ($role == ROLE_RESERVED_ADMIN) {
                    $roleId = $this->db->insertID();
                    $permissionId = $this->db->table('permissions')
                        ->where('permission', PERMISSION_ALL_ACCESS)
                        ->get()
                        ->getRowArray()['id'];

                    $this->db->table('role_permissions')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permissionId
                    ]);
                }
            }
        }

        $this->db->transComplete();
    }
}
