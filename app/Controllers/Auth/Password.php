<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserTokenModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use ReflectionException;

class Password extends BaseController
{
    /**
     * Show forgot password form.
     */
    public function index()
    {
        return view('auth/forgot');
    }

    /**
     * Send email request to password recovery.
     *
     * @throws ReflectionException
     */
    public function forgot()
    {
        if ($this->validate(['email' => 'required|valid_email'])) {
            $email = $this->request->getPost('email');

            $this->db->transStart();

            $user = new UserModel();
            $foundUser = $user->where('email', $email)->get()->getRow();

            if (empty($foundUser)) {
                return redirect()->back()->withInput()
                    ->with('status', 'danger')
                    ->with('message', 'Email is not registered in our system');
            }
            $name = $foundUser->name;

            $token = $this->createToken($email);

            if ($token == false) {
                return redirect()->back()->withInput()
                    ->with('status', 'danger')
                    ->with('message', 'Failed to create reset password token');
            } else {
                $mailer = Services::email();
                $mailer->setTo($email);
                $mailer->setSubject(config('App')->appName . ' - Reset password request');
                $mailer->setMessage(view('emails/reset_password', compact('name', 'email', 'token')));
                $mailer->send();
            }
            return redirect()->to('/login')
                ->with('status', 'success')
                ->with('message', "We have sent email {$email} token to reset your password");
        }
        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', 'Your registration data is invalid');
    }

    /**
     * Generate token by email and return it;
     *
     * @param $email
     * @return bool|string
     * @throws ReflectionException
     */
    public function createToken($email)
    {
        $tokenLength = 32;
        $maxActivation = 1;
        $expiredAt = date('Y-m-d H:i:s', strtotime('+1 day'));

        $userToken = new UserTokenModel();
        $token = $userToken->create($email, UserTokenModel::TOKEN_PASSWORD, $tokenLength, $maxActivation, $expiredAt);

        return $token;
    }

    /**
     * Check if token expired or not.
     *
     * @param $token
     * @param $type
     * @return bool|object
     */
    private function validateToken($token, $type)
    {
        $userToken = new UserTokenModel();
        return $userToken->verifyToken($token, $type, true, true);
    }

    /**
     * Show reset password form.
     *
     * @param $token
     * @return RedirectResponse|string
     */
    public function reset($token)
    {
        $token = $this->validateToken($token, UserTokenModel::TOKEN_PASSWORD);

        if (empty($token) || $token == false) {
            return redirect()->to('/login')
                ->with('status', 'danger')
                ->with('message', "Token invalid or expired");
        }

        return view('auth/reset', compact('token'));
    }

    /**
     * Submit new password and recover account.
     *
     * @param $token
     * @return RedirectResponse
     */
    public function recover($token)
    {
        $token = $this->validateToken($token, UserTokenModel::TOKEN_PASSWORD);

        if (empty($token) || $token == false) {
            return redirect()->to('/login')
                ->with('status', 'danger')
                ->with('message', "Token invalid or expired");
        }

        if ($this->validate('recover')) {
            $password = $this->request->getPost('password');

            $this->db->transStart();

            $user = new UserModel();
            $userData = $user->where('email', $token->email)->get()->getRow();

            $user->where('email', $token->email)
                ->set(['password' => $password])
                ->update();

            $userToken = new UserTokenModel();
            $userToken->where('token', $token->token)->delete();

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                $mailer = Services::email();
                $mailer->setTo($token->email);
                $mailer->setSubject(config('App')->appName . ' - Password recovered');
                $mailer->setMessage(view('emails/password_recovered', ['name' => $userData->name, 'email' => $userData->email]));
                $mailer->send();

                return redirect()->to('/login')
                    ->with('status', 'success')
                    ->with('message', "Your password is recovered");
            }
        }

        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', 'Recover password failed');
    }
}