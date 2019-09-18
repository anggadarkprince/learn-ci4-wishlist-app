<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use App\Models\UserModel;
use App\Models\UserTokenModel;
use ReflectionException;

class Authentication extends BaseController
{
    /**
     * Show default login page.
     * @throws ReflectionException
     */
    public function index()
    {
        if ($this->request->getMethod() == 'post') {
            if ($this->validate('login')) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
                $remember = $this->request->getPost('remember');

                // we limiting login attempt based setting as follow,
                // check if throttle expired is set and not passed yet
                $rateLimit = 10; // minutes
                $maxTries = 3; // attempt
                $throttleExpired = $this->session->get('throttle_expired');
                if (!empty($throttleExpired)) {
                    // reset throttle counter if $rateLimit passed
                    $minutesLock = difference_date(date('Y-m-d H:i'), $throttleExpired, '%r%i');
                    if ($minutesLock <= 0) {
                        $this->session->remove(['throttle', 'throttle_expired']);
                    }
                } else {
                    $minutesLock = 0;
                }

                // check if total login is reached the max to trigger limiting
                $throttle = if_empty($this->session->get('throttle'), 1);
                if ($throttle > $maxTries) {
                    if (empty($throttleExpired)) {
                        $throttleExpired = date('Y-m-d H:i', strtotime($rateLimit . ' minute'));
                        $this->session->set('throttle_expired', $throttleExpired);
                        $minutesLock = difference_date(date('Y-m-d H:i'), $throttleExpired, '%r%i');
                    }
                    $this->session->setFlashdata('status', 'danger');
                    $this->session->setFlashdata('message', 'You attempt to many login, your session is locked for ' . $minutesLock . ' minute(s)');
                } else {
                    $auth = new AuthModel();
                    $authenticated = $auth->authenticate($username, $password, $remember);

                    if ($authenticated === UserModel::STATUS_PENDING || $authenticated === UserModel::STATUS_SUSPENDED) {
                        $this->session->setFlashdata('status', 'danger');
                        $this->session->setFlashdata('message', 'Your account has status <strong>' . $authenticated . '</strong>');
                    } else {
                        if ($authenticated) {
                            // remove login throttle if exist
                            $this->session->remove(['throttle', 'throttle_expired']);

                            // decide where application to go after login
                            $intended = urldecode($this->request->getGet('redirect'));

                            // redirect to intended page if no default application is set up
                            if (empty($intended)) {
                                return redirect()->to('/dashboard');
                            }
                            return redirect($intended);
                        } else {
                            $additionalInfo = '';
                            if ($throttle == $maxTries) {
                                $additionalInfo = ', your session will be locked';
                            } elseif ($throttle == ($maxTries - 1)) {
                                $additionalInfo = ', you have last login try';
                            }
                            $this->session->setFlashdata('status', 'danger');
                            $this->session->setFlashdata('message', 'Username and password mismatch' . $additionalInfo);

                            $throttle++;
                            $this->session->set('throttle', $throttle);
                        }
                    }
                }
            } else {
                $this->session->setFlashdata('status', 'warning');
                $this->session->setFlashdata('message', 'Login data is invalid');
            }
        }

        return view('auth/login');
    }

    /**
     * Signing out logged user.
     */
    public function logout()
    {
        $auth = new AuthModel();
        if ($auth->logout()) {
            helper('cookie');
            $rememberToken = get_cookie('remember_token');
            if (!empty($rememberToken)) {
                delete_cookie('remember_token');
                $userToken = new UserTokenModel();
                $userToken->delete($rememberToken);
            }
            if (get_url_param('force_logout', false)) {
                $this->session->setFlashdata('status', 'danger');
                $this->session->setFlashdata('message', 'You are kicked out because you are currently active in another device');
            } else {
                $this->session->setFlashdata('status', 'warning');
                $this->session->setFlashdata('message', 'You are logged out');
            }
            return redirect()->to('/login');
        }
        return redirect()->back();
    }

}