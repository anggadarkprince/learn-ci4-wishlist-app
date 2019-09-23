<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\User';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'username', 'email', 'password', 'avatar', 'about', 'status', 'last_logged_in'];
    protected $useTimestamps = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    const STATUS_PENDING = 'PENDING';
    const STATUS_ACTIVATED = 'ACTIVATED';
    const STATUS_SUSPENDED = 'SUSPENDED';

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

    /**
     * Filter data by conditions.
     *
     * @param array $filters
     * @return BaseModel|BaseBuilder
     */
    public function filter($filters = [])
    {
        return parent::filter($filters)
            ->select([
                'users.*',
                'GROUP_CONCAT(DISTINCT roles.role) AS roles'
            ])
            ->join('user_roles', 'user_roles.user_id = users.id', 'left')
            ->join('roles', 'roles.id = user_roles.role_id', 'left')
            ->groupBy('users.id');
    }
}
