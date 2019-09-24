<?php

namespace App\Models;

class WishlistDetailModel extends BaseModel
{
    protected $table = 'wishlist_details';
    protected $returnType = 'object';

    protected $allowedFields = ['wishlist_id', 'detail'];
    protected $useTimestamps = true;
}
