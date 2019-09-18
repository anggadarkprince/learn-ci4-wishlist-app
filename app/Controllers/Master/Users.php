<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Libraries\Exporter;
use App\Libraries\File;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\UserRoleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class Users extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    /**
     * Show index user data.
     *
     * @return string
     */
    public function index()
    {
        $title = 'User';
        $data = $this->user->filter($_GET);

        if ($this->request->getGet('export')) {
            $exporter = new Exporter();
            $filePath = $exporter->exportFromArray($title, $data->asArray()->findAll());
            return $this->response->download($filePath, null, true);
        } else {
            $users = $data->paginate();
            $pager = $this->user->pager;
        }

        return view('users/index', compact('title', 'users', 'pager'));
    }

    /**
     * Show single user data.
     *
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $title = 'View user';

        $user = $this->user->find($id);

        $userRole = new UserRoleModel();
        $roles = $userRole->filter()->where('user_id', $id)->findAll();

        return view('users/view', compact('user', 'roles', 'title'));
    }

    /**
     * Show create user data form.
     *
     * @return string
     */
    public function new()
    {
        $title = 'New user';

        $role = new RoleModel();
        $roles = $role->findAll();

        return view('users/new', compact('roles', 'title'));
    }

    /**
     * Save new user data.
     *
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function create()
    {
        if ($this->validate('users')) {
            $data = $this->request->getPost();

            $file = $this->request->getFile('avatar');
            if (!empty($file)) {
                $fileName = $file->getRandomName();
                $fileDirectory = 'avatars/' . date('Y/m/');

                $fileHandler = new File();
                $fileHandler->makeFolder('uploads/' . $fileDirectory);

                $filePath = WRITEPATH . 'uploads/' . $fileDirectory;
                $file->move($filePath, $fileName);

                $data['avatar'] = $fileDirectory . $fileName;
            }

            $this->db->transStart();

            $this->user->insert($data);
            $userId = $this->db->insertID();

            $userRole = new UserRoleModel();
            foreach ($this->request->getPost('roles') as $roleId) {
                $userRole->insert([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/master/users')
                    ->with('status', 'success')
                    ->with('message', "User {$this->request->getPost('name')} successfully created");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', "Create user {$this->request->getPost('name')} failed, try again or contact administrator");
    }

    /**
     * Show edit user data form.
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $title = 'Edit user';
        $user = $this->user->find($id);

        if ($user->username == USER_RESERVED_ADMIN) {
            return redirect()->back()
                ->with('status', 'warning')
                ->with('message', "Reserved user {$user->username} cannot be edited");
        }

        $role = new RoleModel();
        $roles = $role->findAll();

        $userRole = new UserRoleModel();
        $userRoles = $userRole->where('user_id', $id)->findAll();

        return view('users/edit', compact('user', 'roles', 'userRoles', 'title'));
    }

    /**
     * Update user data.
     *
     * @param $id
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function update($id)
    {
        $rules = [
            'name' => 'trim|required|max_length[50]',
            'username' => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'email' => 'required|max_length[50]|is_unique[users.email,id,' . $id . ']',
            'confirm_password' => 'matches[password]',
            'status' => 'required',
            'roles' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = $this->request->getPost();

            $user = $this->user->find($id);

            $file = $this->request->getFile('avatar');
            if (!empty($file)) {
                $fileName = $file->getRandomName();
                $fileDirectory = 'avatars/' . date('Y/m/');

                $fileHandler = new File();
                $fileHandler->makeFolder('uploads/' . $fileDirectory);

                $filePath = WRITEPATH . 'uploads/' . $fileDirectory;
                $file->move($filePath, $fileName);

                $data['avatar'] = $fileDirectory . $fileName;
            } else {
                $data['avatar'] = $user->avatar;
            }

            $this->db->transStart();

            $this->user->update($id, $data);

            $userRole = new UserRoleModel();
            $userRole->where('user_id', $id)->delete();
            foreach ($this->request->getPost('roles') as $roleId) {
                $userRole->insert([
                    'user_id' => $id,
                    'role_id' => $roleId
                ]);
            }

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                return redirect()->to('/master/users')
                    ->with('status', 'success')
                    ->with('message', "User {$this->request->getPost('user')} successfully updated");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'danger')
            ->with('message', "Update user {$this->request->getPost('user')} failed");
    }

    /**
     * Delete user data.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->user->find($id);

        if ($this->user->delete($id)) {
            return redirect()->back()
                ->with('status', 'warning')
                ->with('message', "User {$user->user} successfully deleted");
        }

        return redirect()->back()
            ->with('status', 'danger')
            ->with('message', "Delete user {$user->user} failed");
    }
}
