<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['role', 'description'];
    protected $useTimestamps = true;
}
