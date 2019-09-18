<?php

namespace App\Models;

class UserRoleModel extends BaseModel
{
    protected $table = 'user_roles';

    protected $returnType = 'object';

    protected $allowedFields = ['user_id', 'role_id'];

    public function filter($filters = [])
    {
        return parent::filter($filters)
            ->select([
                'user_roles.*',
                'roles.role',
                'roles.description'
            ])
            ->join('roles', 'roles.id = user_roles.role_id');
    }
}
