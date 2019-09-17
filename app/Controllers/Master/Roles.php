<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Libraries\Exporter;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use CodeIgniter\HTTP\RedirectResponse;

class Roles extends BaseController
{
    private $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    /**
     * Show index role data.
     *
     * @return string
     */
    public function index()
    {
        $title = 'Role';
        $data = $this->role->filter($_GET);

        if ($this->request->getGet('export')) {
            $roles = $data->asArray()->findAll();
            $exporter = new Exporter();
            $filePath = $exporter->exportFromArray($title, $roles);
            return $this->response->download($filePath, null, true);
        } else {
            $roles = $data->paginate();
            $pager = $this->role->pager;
        }

        return view('roles/index', compact('title', 'roles', 'pager'));
    }

    /**
     * Show single role data.
     *
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $title = 'View role';
        $role = $this->role->find($id);

        $permission = new PermissionModel();
        $permissions = $permission->getByRole($id);

        return view('roles/view', compact('role', 'permissions', 'title'));
    }

    /**
     * Show create role data form.
     *
     * @return string
     */
    public function new()
    {
        $title = 'New role';
        $permission = new PermissionModel();
        $permissions = $permission->findAll();

        return view('roles/new', compact('permissions', 'title', 'validation'));
    }

    /**
     * Save new role data.
     *
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function create()
    {
        if ($this->validate('roles')) {
            $this->db->transStart();

            $this->role->insert($this->request->getPost());
            $roleId = $this->db->insertID();

            $rolePermission = new RolePermissionModel();
            foreach ($this->request->getPost('permissions') as $permissionId) {
                $rolePermission->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/master/roles')
                    ->with('status', 'success')
                    ->with('message', "Role {$this->request->getPost('role')} successfully created");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', "Create role {$this->request->getPost('role')} failed, try again or contact administrator");
    }

    /**
     * Show edit role data form.
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $title = 'Edit role';
        $role = $this->role->find($id);

        if ($role->role == ROLE_RESERVED_ADMIN) {
            return redirect()->back()
                ->with('status', 'warning')
                ->with('message', "Reserved role {$role->role} cannot be edited");
        }

        $permission = new PermissionModel();
        $permissions = $permission->findAll();

        $rolePermission = new RolePermissionModel();
        $rolePermissions = $rolePermission->where(['role_id' => $id])->findAll();

        return view('roles/edit', compact('role', 'permissions', 'rolePermissions', 'title'));
    }

    /**
     * Update role data.
     *
     * @param $id
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function update($id)
    {
        $rules = [
            'role' => 'required|max_length[50]|is_unique[roles.role,id,' . $id . ']',
            'description' => 'max_length[500]',
            'permissions' => 'required'
        ];

        if ($this->validate($rules)) {
            $this->db->transStart();

            $this->role->update($id, $this->request->getPost());

            $rolePermission = new RolePermissionModel();
            $rolePermission->where('role_id', $id)->delete();
            foreach ($this->request->getPost('permissions') as $permissionId) {
                $rolePermission->insert([
                    'role_id' => $id,
                    'permission_id' => $permissionId
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/master/roles')
                    ->with('status', 'success')
                    ->with('message', "Role {$this->request->getPost('role')} successfully updated");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'danger')
            ->with('message', "Update role {$this->request->getPost('role')} failed");
    }

    /**
     * Delete role data.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $role = $this->role->find($id);
        if ($this->role->delete($id)) {
            return redirect()->back()
                ->with('status', 'warning')
                ->with('message', "Role {$role->role} successfully deleted");
        }
        return redirect()->back()
            ->with('status', 'danger')
            ->with('message', "Delete role {$role->role} failed");
    }
}
