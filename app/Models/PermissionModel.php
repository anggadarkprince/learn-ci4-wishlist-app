<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $returnType = 'object';

    /**
     * Get permissions of a role.
     *
     * @param int $id
     * @return array
     */
    public function getByRole($id)
    {
        $permissions = $this->join('role_permissions', 'role_permissions.permission_id = permissions.id')
            ->join('roles', 'role_permissions.role_id = roles.id')
            ->where('roles.id', $id);

        return $permissions->get()->getResult();
    }
}
