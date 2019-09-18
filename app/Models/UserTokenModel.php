<?php

namespace App\Models;

use ReflectionException;

class UserTokenModel extends BaseModel
{
    protected $table = 'user_tokens';
    protected $primaryKey = 'token';

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
        helper('string');
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
     * @return bool|string
     */
    public function verifyToken($token, $tokenType)
    {
        $token = $this->getWhere([
            'token' => $token,
            'type' => $tokenType
        ])->getRow();

        if (!empty($token)) {
            return $token->email;
        }

        return false;
    }

    /**
     * Get token data by it's token value.
     *
     * @param $token
     * @param bool $checkActivation
     * @param bool $checkExpiredDate
     * @return mixed
     */
    public function getByTokenKey($token, $checkActivation = false, $checkExpiredDate = false)
    {
        $userToken = $this->where('token', $token);

        if ($checkActivation) {
            $userToken->where('max_activation >', 0);
        }

        if ($checkExpiredDate) {
            $userToken->where('expired_at >= DATE(NOW())');
        }

        return $userToken->get()->getRow();
    }

    /**
     * Activate token use, decrease token max activation value.
     *
     * @param $token
     * @return mixed
     * @throws ReflectionException
     */
    public function activateToken($token)
    {
        $tokenData = $this->getByTokenKey($token, true);

        if (empty($tokenData)) {
            return false;
        }

        $result = $this->update([
            'max_activation' => $tokenData['max_activation'] - 1,
        ], ['token' => $token]);

        return $result;
    }

}