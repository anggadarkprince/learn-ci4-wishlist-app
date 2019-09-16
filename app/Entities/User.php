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
        'full_name' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    protected $datamap = [
        'name' => 'full_name'
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

    /**
     * Get created at value.
     *
     * @param string $format
     * @return mixed
     * @throws Exception
     */
    public function getCreatedAt(string $format = 'd F Y H:i')
    {
        try {
            $this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);
        } catch (Exception $e) {
            $this->attributes['created_at'] = (new DateTime('now'));
        }

        $timezone = $this->timezone ?? app_timezone();

        $this->attributes['created_at']->setTimezone($timezone);

        return $this->attributes['created_at']->format($format);
    }

    /**
     * Get updated at value.
     *
     * @param string $format
     * @return mixed
     * @throws Exception
     */
    public function getUpdatedAt(string $format = 'd F Y H:i')
    {
        try {
            $this->attributes['updated_at'] = $this->mutateDate($this->attributes['updated_at']);
        } catch (Exception $e) {
            $this->attributes['updated_at'] = (new DateTime('now'));
        }

        $timezone = $this->timezone ?? app_timezone();

        $this->attributes['updated_at']->setTimezone($timezone);

        return $this->attributes['updated_at']->format($format);
    }
}