<?php

namespace App\Controllers\Wishlist;

use App\Controllers\BaseController;
use App\Libraries\Exporter;
use App\Models\WishlistDetailModel;
use App\Models\WishlistModel;
use App\Models\WishlistParticipantModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class Discovery extends BaseController
{
    private $wishlist;

    public function __construct()
    {
        $this->wishlist = new WishlistModel();
    }

    /**
     * Show index wishlist data.
     *
     * @return string
     */
    public function index()
    {
        $title = 'Wishlist';

        $filters = $_GET;
        $filters['public'] = true;
        $data = $this->wishlist->filter($filters);

        $wishlists = $data->paginate();

        $wishlistParticipant = new WishlistParticipantModel();
        foreach ($wishlists as &$wishlist) {
            $wishlist->participants = $wishlistParticipant->filter(['wishlist' => $wishlist->id])->findAll();
        }
        $pager = $this->wishlist->pager;

        return view('discovery/index', compact('title', 'wishlists', 'pager'));
    }

}
