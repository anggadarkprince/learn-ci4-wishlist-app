<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;

class WishlistModel extends BaseModel
{
    protected $table = 'wishlists';

    protected $returnType = 'App\Entities\Wishlist';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'wish', 'description', 'target', 'progress', 'is_private', 'is_completed', 'completed_at'];
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
                'wishlists.*',
                'users.name',
                'users.username',
                'users.avatar',
            ])
            ->join('users', 'users.id = wishlists.user_id');


        if (key_exists('q', $filters) && !empty($filters['q'])) {
            $fields = $this->db->getFieldData($this->table);
            foreach ($fields as $field) {
                if ($field->name != 'id' && !preg_match('/_id/', $field->name)) {
                    $this->orLike($this->table . '.' . $field->name, trim($filters['q']));
                }
            }
            $this->orLike('users.name', trim($filters['q']));
            $this->orLike('users.username', trim($filters['q']));
            $this->orLike('users.email', trim($filters['q']));
        }

        if (key_exists('is_completed', $filters) && !is_null($filters['is_completed']) && $filters['is_completed'] != '') {
            $this->where('wishlists.is_completed', $filters['is_completed']);
        }

        if (key_exists('shared', $filters) && $filters['shared']) {
            $this->join('wishlist_participants', 'wishlist_participants.wishlist_id = wishlists.id');
            $this->where('wishlist_participants.user_id', $filters['users']);
        } else {
            if (key_exists('users', $filters) && !empty($filters['users'])) {
                $this->where('users.id', $filters['users']);
            }
        }

        if (key_exists('public', $filters) && $filters['public']) {
            $this->where('is_private', false);
        }

        return $baseQuery;
    }
}
