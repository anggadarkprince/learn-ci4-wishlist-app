<?php

namespace App\Entities;

use CodeIgniter\Entity;
use DateTime;
use Exception;

class User extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $attributes = [
        'id' => null,
        'name' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    /**
     * Auto convert password with hash version.
     *
     * @param string $pass
     * @return $this
     */
    public function setPassword(string $pass)
    {
        $this->password = password_hash($pass, PASSWORD_BCRYPT);

        return $this;
    }

}