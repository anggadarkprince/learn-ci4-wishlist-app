<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\User';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'username', 'email', 'password', 'about', 'status', 'last_logged_in'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|max_length[100]',
        'username' => 'required|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|max_length[50]|is_unique[users.email,id,{id}]',
        'password' => 'required|max_length[50]',
    ];


    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before insert or update.
     *
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        if (strlen($data['data']['password']) <= 50) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }

        return $data;
    }
}
