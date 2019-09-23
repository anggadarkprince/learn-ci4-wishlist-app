<?php

namespace App\Models;

class WishlistModel extends BaseModel
{
    protected $table = 'wishlists';

    protected $returnType = 'App\Entities\Wishlist';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'wish', 'description', 'target', 'progress', 'is_private', 'is_completed', 'completed_at'];
    protected $useTimestamps = true;
}
