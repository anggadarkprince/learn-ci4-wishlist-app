<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use CodeIgniter\HTTP\RedirectResponse;

class Roles extends BaseController
{
    private $role;

    public function __construct()
    {
        $this->role = new RoleModel();
    }

    /**
     * Show role data.
     */
    public function index()
    {
        $data = [
            'roles' => $this->role->paginate(),
            'pager' => $this->role->pager,
            'title' => 'Role'
        ];
        return view('roles/index', $data);
    }

    public function show($id)
    {
        $title = 'View role';
        $role = $this->role->find($id);

        return view('roles/view', compact('role', 'title'));
    }

    /**
     * Show create role data form.
     */
    public function new()
    {
        $title = 'New role';
        $permission = new PermissionModel();
        $permissions = $permission->findAll();

        return view('roles/new', compact('permissions', 'title'));
    }

    /**
     * Save new role data.
     *
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function create()
    {
        if ($this->role->insert($this->request->getPost())) {
            return redirect()->to('master/roles')
                ->with('status', 'warning')
                ->with('message', "Role {$this->request->getPost('role')} successfully created");
        }

        return redirect()->to('master/roles')
            ->with('status', 'warning')
            ->with('message', "Create role {$this->request->getPost('role')} failed");
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

        $permission = new PermissionModel();
        $permissions = $permission->findAll();

        return view('roles/edit', compact('role', 'permissions', 'title'));
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
        if ($this->role->update($id, $this->request->getPost())) {
            return redirect()->to('master/roles')
                ->with('status', 'warning')
                ->with('message', "Role {$this->request->getPost('role')} successfully updated");
        }

        return redirect()->to('master/roles')
            ->with('status', 'warning')
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
