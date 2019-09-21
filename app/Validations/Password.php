<?php

namespace App\Validations;

class Password
{
    /**
     * Check if the password is current logged in user password.
     *
     * @param string $password
     * @param string|null $error
     * @return bool
     */
    public function password_granted(string $password, string &$error = null): bool
    {
        $currentPassword = auth('password');
        if (password_verify($password, $currentPassword)) {
            return true;
        }
        $error = 'You must input correct password';
        return false;
    }

}