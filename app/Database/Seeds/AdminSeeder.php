<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $isAdminExist = $this->db->table('users')
            ->where('username', 'admin')
            ->countAllResults();

        if (!$isAdminExist) {
            $this->db->transStart();

            $roleId = $this->db->table('roles')
                ->where('role', ROLE_RESERVED_ADMIN)
                ->get()
                ->getRowArray()['id'];

            $this->db->table('users')->insert([
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@wishlist.app',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
                'status' => 'ACTIVATED'
            ]);
            $userId = $this->db->insertID();

            $this->db->table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId
            ]);

            $this->db->transComplete();
        }
    }
}
