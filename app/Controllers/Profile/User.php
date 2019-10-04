<?php

namespace App\Controllers\Profile;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WishlistModel;
use App\Models\WishlistParticipantModel;

class User extends BaseController
{
    private $user;
    private $wishlist;
    private $wishlistParticipant;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->wishlist = new WishlistModel();
        $this->wishlistParticipant = new WishlistParticipantModel();
    }

    /**
     * Show profile page.
     *
     * @param $username
     * @return string
     */
    public function index($username)
    {
        $data = $this->getProfileData($username);

        return view('profile/index', $data);
    }

    /**
     * Show shared profile with me.
     *
     * @param $username
     * @return string
     */
    public function shared($username)
    {
        $data = $this->getProfileData($username, null, true);

        return view('profile/index', $data);
    }

    /**
     * Show completed profile.
     *
     * @param $username
     * @return string
     */
    public function completed($username)
    {
        $data = $this->getProfileData($username, 1);

        return view('profile/index', $data);
    }

    /**
     * Get profile data.
     *
     * @param $username
     * @param null $isCompleted
     * @param bool $shared
     * @return array
     */
    private function getProfileData($username, $isCompleted = null, $shared = false)
    {
        $user = $this->user->where('username', $username)->first();

        $title = $user->name;
        $wishlists = $this->wishlist->filter([
            'users' => $user->id,
            'is_completed' => $isCompleted,
            'shared' => $shared,
        ])->paginate();

        foreach ($wishlists as &$wishlist) {
            $wishlist->participants = $this->wishlistParticipant->filter(['wishlist' => $wishlist->id])->findAll();
        }

        $pager = $this->wishlist->pager;
        $section = $this->request->uri->getSegment(2);

        return compact('title', 'user', 'wishlists', 'pager', 'section');
    }

}
