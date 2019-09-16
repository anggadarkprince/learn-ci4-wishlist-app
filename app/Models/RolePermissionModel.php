<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $returnType = 'object';

    protected $allowedFields = ['role_id', 'permission_id'];
}
