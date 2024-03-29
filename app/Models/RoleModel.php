<?php

namespace App\Models;

class RoleModel extends BaseModel
{
    protected $table = 'roles';

    protected $returnType = 'App\Entities\Role';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['role', 'description'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'role' => 'required|max_length[50]',
        'description' => 'max_length[500]',
    ];
}
