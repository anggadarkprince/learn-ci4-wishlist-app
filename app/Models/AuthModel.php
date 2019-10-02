<?php

namespace App\Models;

use Config\Database;
use Config\Services;
use ReflectionException;

class AuthModel extends BaseModel
{
    protected $table = 'users';
    protected $allowedFields = ['last_logged_in'];

    /**
     * Check user authentication and remembering login.
     *
     * @param string $username
     * @param string $password
     * @param $remember
     * @return array
     * @throws ReflectionException
     */
    public function authenticate($username, $password, $remember)
    {
        $usernameField = 'username';
        $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL);
        if ($isEmail) {
            $usernameField = 'email';
        }

        $user = $this->getWhere([$usernameField => $username])->getRow();

        if (!empty($user)) {
            if ($user->status != UserModel::STATUS_ACTIVATED) {
                return ['status' => true, 'user' => $user];
            }
            $hashedPassword = $user->password;
            if (password_verify($password, $hashedPassword)) {
                if (password_needs_rehash($hashedPassword, PASSWORD_BCRYPT)) {
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    $this->update($user->id, ['password' => $newHash]);
                }
                $session = Services::session();
                $session->set('auth', [
                    'id' => $user->id,
                    'is_logged_in' => true
                ]);

                $this->update($user->id, [
                    'last_logged_in' => date('Y-m-d H:i:s')
                ]);

                if ($remember || $remember == 'on') {
                    $userToken = new UserTokenModel();

                    $loggedEmail = $user->email;
                    $token = $userToken->create($loggedEmail, UserTokenModel::TOKEN_REMEMBER);

                    if ($token) {
                        helper('cookie');
                        set_cookie('remember_token', $token, 3600 * 24 * 30);
                        $session->push('auth', [
                            'remember_me' => true,
                            'remember_token' => $token
                        ]);
                    }
                }

                return ['status' => true, 'user' => $user];
            }
        }
        return ['status' => false, 'user' => $user];
    }

    /**
     * Destroy user's session
     */
    public function logout()
    {
        $session = Services::session();
        if ($session->has('auth')) {
            $session->remove('auth');
            $session->destroy(); // optional
            return true;
        }
        return false;
    }

    /**
     * Check if user has logged in from everywhere.
     * @return bool
     */
    public static function isLoggedIn()
    {
        $session = Services::session();
        $sessionUserId = $session->get('auth.id');
        if (empty($sessionUserId)) {
            return false;
        }

        return true;
    }

    /**
     * Get authenticate user data.
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public static function loginData($key = '', $default = '')
    {
        $session = Services::session();
        $id = 0;
        if ($session->has('auth') && !empty($session->get('auth.id'))) {
            $id = $session->get('auth.id');
        }
        $result = Database::connect()
            ->table('users')
            ->where(['id' => $id])
            ->get()
            ->getRow();

        if (empty($result)) {
            return $default;
        }

        if (!is_null($key) && $key != '') {
            if (key_exists($key, $result)) {
                return $result->$key;
            }
            return $default;
        }
        return $result;
    }

    /**
     * Quick check user permission.
     *
     * @param $permission
     * @param null $redirect
     * @return string|void
     */
    public static function mustAuthorized($permission, $redirect = null)
    {
        if (!self::isAuthorized($permission)) {
            $request = Services::request();
            $response = Services::response();
            $session = Services::session();
            $agent = $request->getUserAgent();

            $message = 'You are unauthorized to perform this action.';

            if ($request->isAJAX()) {
                return $message;
            } else {
                $session->setFlashdata([
                    'status' => 'danger',
                    'message' => $message,
                ]);
            }

            $redirectModule = if_empty($redirect, '/', '/');

            $response->setHeader('Location', if_empty($agent->getReferrer(), $redirectModule))->send();
        }
    }

    /**
     * Check authorization by granted or denied point of view.
     *
     * @param $permissions
     * @param $userId
     * @return bool
     */
    public static function isAuthorized($permissions, $userId = null)
    {
        if (empty($userId)) $userId = self::loginData('id', 0);

        if (!is_array($permissions) && is_string($permissions)) $permissions = [$permissions];

        $permissionQuery = Database::connect()->table('users')
            ->select(['permissions.id', 'permissions.permission'])
            ->join('user_roles', 'users.id = user_roles.user_id')
            ->join('roles', 'user_roles.role_id = roles.id')
            ->join('role_permissions', 'roles.id = role_permissions.role_id')
            ->join('permissions', 'role_permissions.permission_id = permissions.id')
            ->where('users.id', $userId)
            ->groupStart()
            ->whereIn('permissions.permission', $permissions)
            ->orWhere('permissions.permission', PERMISSION_ALL_ACCESS)
            ->orWhere('users.username', 'admin')
            ->groupEnd()
            ->get()
            ->getRow();

        if (!empty($permissionQuery)) {
            return true;
        }

        return false;
    }
}
