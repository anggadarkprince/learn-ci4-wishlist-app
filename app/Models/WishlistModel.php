<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wissthlist';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['role', 'description'];
    protected $useTimestamps = true;
}
