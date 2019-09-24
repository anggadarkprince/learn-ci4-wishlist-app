<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

class WishlistParticipantModel extends BaseModel
{
    protected $table = 'wishlist_participants';
    protected $returnType = 'object';

    protected $allowedFields = ['wishlist_id', 'user_id', 'is_confirmed', 'confirmed_at', 'description'];
    protected $useTimestamps = true;

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
                'wishlist_participants.*',
                'users.name',
                'users.username',
                'users.avatar',
                'wishlists.wish',
            ])
            ->join('users', 'users.id = wishlist_participants.user_id')
            ->join('wishlists', 'wishlists.id = wishlist_participants.wishlist_id');

        if (key_exists('wishlist', $filters) && !empty($filters['wishlist'])) {
            $this->where('wishlist_id', $filters['wishlist']);
        }

        return $baseQuery;
    }
}
