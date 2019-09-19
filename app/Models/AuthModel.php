<?php

namespace App\Models;

use App\Entities\User;
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
        if ($session->has('auth.id')) {
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
}
