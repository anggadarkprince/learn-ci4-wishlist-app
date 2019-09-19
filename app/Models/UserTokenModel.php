<?php

namespace App\Models;

use ReflectionException;

class UserTokenModel extends BaseModel
{
    protected $table = 'user_tokens';
    protected $primaryKey = 'token';

    protected $allowedFields = ['email', 'token', 'type', 'max_activation', 'expired_at'];

    const TOKEN_REMEMBER = 'REMEMBER';
    const TOKEN_PASSWORD = 'PASSWORD';
    const TOKEN_REGISTRATION = 'REGISTRATION';

    /**
     * Generate token for one authenticate of credential of several
     * actions such as registration or reset password.
     *
     * @param $email
     * @param string $tokenType
     * @param int $length
     * @param int $maxActivation
     * @param null $expired_at
     * @return bool|string
     * @throws ReflectionException
     */
    public function create($email, $tokenType = self::TOKEN_REGISTRATION, $length = 32, $maxActivation = 1, $expired_at = null)
    {
        helper('text');
        $token = random_string('alnum', $length);

        $isTokenEmailExist = $this->where([
            'email' => $email,
            'type' => $tokenType
        ])->countAllResults();

        if ($isTokenEmailExist) {
            $result = $this->update([
                'email' => $email,
                'type' => $tokenType
            ], [
                'token' => $token,
                'max_activation' => $maxActivation,
                'expired_at' => $expired_at,
            ]);
        } else {
            $result = $this->insert([
                'email' => $email,
                'token' => $token,
                'type' => $tokenType,
                'max_activation' => $maxActivation,
                'expired_at' => $expired_at,
            ]);
        }

        if ($result) {
            return $token;
        }

        return false;
    }

    /**
     * Check if given token is valid.
     *
     * @param string $token
     * @param string $tokenType
     * @param bool $checkActivation
     * @param bool $checkExpiredDate
     * @return bool|object
     */
    public function verifyToken($token, $tokenType, $checkActivation = false, $checkExpiredDate = false)
    {
        $token = $this->where([
            'token' => $token,
            'type' => $tokenType
        ]);

        if ($checkActivation) {
            $token->where('max_activation >', 0);
        }

        if ($checkExpiredDate) {
            $token->where('expired_at >= DATE(NOW())');
        }

        $result = $token->get()->getRow();

        if (!empty($result)) {
            return $result;
        }

        return false;
    }

    /**
     * Activate token use, decrease token max activation value.
     *
     * @param $token
     * @param $type
     * @return mixed
     * @throws ReflectionException
     */
    public function activateToken($token, $type)
    {
        $tokenData = $this->verifyToken($token, $type, true);

        if (empty($tokenData)) {
            return false;
        }

        $result = $this->update($token, [
            'max_activation' => $tokenData->max_activation - 1,
        ]);

        return $result;
    }

}