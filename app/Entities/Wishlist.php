<?php

namespace App\Entities;

use CodeIgniter\Entity;
use Exception;

class Wishlist extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'completed_at', 'target'];
    protected $casts = [
        'is_private' => 'boolean',
        'is_completed' => '?boolean',
        'progress' => 'integer',
    ];

    /**
     * Set target value.
     *
     * @param string $dateString
     * @return $this
     */
    public function setTarget(string $dateString)
    {
        $timezone = $this->timezone ?? app_timezone();

        try {
            $date = $this->mutateDate($dateString)->setTimezone($timezone);
        } catch (Exception $e) {
            $date = $dateString;
        }

        $this->attributes['created_at'] = $date->format('Y-m-d');

        return $this;
    }

    /**
     * Set completed at value.
     *
     * @param string $dateString
     * @return $this
     */
    public function setCompletedAt(string $dateString)
    {
        $timezone = $this->timezone ?? app_timezone();

        try {
            $date = $this->mutateDate($dateString)->setTimezone($timezone);
        } catch (Exception $e) {
            $date = $dateString;
        }

        $this->attributes['created_at'] = $date->format('Y-m-d H:i:s');

        return $this;
    }
}