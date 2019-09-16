<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';

    protected $returnType = 'App\Entities\Role';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['role', 'description'];
    protected $useTimestamps = true;

    protected $validationRules    = [
        'role' => 'required|max_length[50]|is_unique[roles.role,id,{id}]',
        'description' => 'required|max_length[500]',
        'permissions' => 'required'
    ];
}
