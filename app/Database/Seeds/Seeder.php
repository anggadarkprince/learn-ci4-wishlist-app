<?php

namespace App\Database\Seeds;

class Seeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->call('PermissionSeeder');
        $this->call('SettingSeeder');
        $this->call('RoleSeeder');
        $this->call('AdminSeeder');
    }
}
