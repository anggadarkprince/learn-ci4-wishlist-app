<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use App\Models\UserModel;
use App\Models\UserTokenModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use ReflectionException;

class Register extends BaseController
{
    /**
     * Show register form.
     */
    public function index()
    {
        return view('auth/register');
    }

    /**
     * @throws ReflectionException
     */
    public function register()
    {
        if ($this->validate('register')) {
            $name = $this->request->getPost('name');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $this->db->transStart();

            $user = new UserModel();
            $user->insert([
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, CRYPT_BLOWFISH),
                'status' => UserModel::STATUS_PENDING
            ]);

            $token = $this->createToken($email);

            $this->db->transComplete();

            if ($this->db->transStatus()) {
                $this->sendEmailConfirmation($email, $name, $token);

                $resendLink = ", if you not receive the email please <strong><a href='" . site_url('register/resend?email=' . $email) . "'>click this link</a></strong>";
                $this->session->setFlashdata('status', 'success');
                $this->session->setFlashdata('message', 'You are successfully registered, we sent email to ' . $email . ' to activate your account' . $resendLink);
            } else {
                $this->session->setFlashdata('status', 'danger');
                $this->session->setFlashdata('message', 'Register user failed, or contact our support for further information');
            }
            return redirect()->to('/login');
        }
        return redirect()->back()->withInput()
            ->with('status', 'warning')
            ->with('message', 'Your registration data is invalid');
    }

    /**
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function resend()
    {
        $email = $this->request->getGet('email');

        $user = new UserModel();
        $foundUser = $user->where('email', $email)->get()->getRow();
        if (empty($email) || empty($foundUser) || $foundUser->status != UserModel::STATUS_PENDING) {
            return redirect()->to('/login')
                ->with('status', 'danger')
                ->with('message', 'Email not found, or user already activated');
        }

        $this->db->transStart();

        $userToken = new UserTokenModel();
        $userToken->where([
            'email' => $email,
            'type' => UserTokenModel::TOKEN_REGISTRATION
        ])->delete();

        $token = $this->createToken($email);

        $this->db->transComplete();

        if ($this->db->transStatus()) {
            $this->sendEmailConfirmation($foundUser->email, $foundUser->name, $token);

            $resendLink = ", if you not receive the email again please <strong><a href='" . site_url('register/resend?email=' . $email) . "'>click this link</a></strong>";
            return redirect()->to('/login')
                ->with('status', 'success')
                ->with('message', 'We already resent you confirmation email' . $resendLink);
        }

        return redirect()->to('/login')
            ->with('status', 'danger')
            ->with('message', 'Resend email failed');
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
        $expiredAt = date('Y-m-d H:i:s', strtotime('+7 day'));

        $userToken = new UserTokenModel();
        $token = $userToken->create($email, UserTokenModel::TOKEN_REGISTRATION, $tokenLength, $maxActivation, $expiredAt);

        return $token;
    }

    /**
     * Send email confirmation to user.
     *
     * @param $email
     * @param $name
     * @param $token
     */
    private function sendEmailConfirmation($email, $name, $token)
    {
        $mailer = Services::email();
        $mailer->setTo($email);
        $mailer->setSubject(config('App')->appName . ' - Please confirm to activate your account');
        $mailer->setMessage(view('emails/registration', compact('name', 'email', 'token')));
        $mailer->send();
    }

    /**
     * Confirm the account.
     *
     * @param $token
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function confirm($token)
    {
        $userToken = new UserTokenModel();
        $validToken = $userToken->getByTokenKey($token, true, true);

        if (empty($validToken)) {
            return redirect()->to('/login')
                ->with('status', 'danger')
                ->with('message', 'Token is invalid or expired');
        }
        $this->db->transStart();

        $userToken->activateToken($token);

        $user = new UserModel();
        $foundUser = $user->where('email', $validToken->email)->get()->getRow();

        $user->update($foundUser->id, ['status' => UserModel::STATUS_ACTIVATED]);

        $userToken = new UserTokenModel();
        $userToken->where('token', $token)->delete();

        $this->db->transComplete();

        if ($this->db->transStatus()) {
            return redirect()->to('/login')
                ->with('status', 'success')
                ->with('message', 'Congratulation, you are a Wishliscious and the account is activated');
        }

        return redirect()->to('/login')
            ->with('status', 'danger')
            ->with('message', 'Activating user failed, try again or contact our support');
    }

}