<?php

namespace App\Filters;

use App\Models\AuthModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MustAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        if (!AuthModel::isLoggedIn()) {
            helper('url');
            $redirectTo = '?redirect=' . urlencode(current_url());
            return redirect()->to('/login' . $redirectTo);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
