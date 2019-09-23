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
}