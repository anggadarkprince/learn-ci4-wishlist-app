<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

class WishlistSupportModel extends BaseModel
{
    protected $table = 'wishlist_supports';
    protected $returnType = 'object';

    protected $allowedFields = ['wishlist_id', 'user_id'];

    /**
     * Filter data by conditions.
     *
     * @param array $filters
     * @return BaseModel|BaseBuilder
     */
    public function filter($filters = [])
    {
        $baseQuery = parent::filter($filters)
            ->select([
                'wishlist_supports.*',
                'users.name',
                'users.username',
                'users.avatar',
                'wishlists.wish',
            ])
            ->join('users', 'users.id = wishlist_supports.user_id')
            ->join('wishlists', 'wishlists.id = wishlist_supports.wishlist_id');

        if (key_exists('wishlist', $filters) && !empty($filters['wishlist'])) {
            $this->where('wishlist_id', $filters['wishlist']);
        }

        return $baseQuery;
    }
}
