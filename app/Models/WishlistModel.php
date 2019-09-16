<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wishlists';

    protected $returnType = 'App\Entities\Wishlist';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'wish', 'description', 'target', 'progress', 'is_private', 'is_completed', 'completed_at'];
    protected $useTimestamps = true;
}
