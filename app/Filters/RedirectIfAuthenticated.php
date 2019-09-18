<?php

namespace App\Filters;

use App\Models\AuthModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RedirectIfAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        if (AuthModel::isLoggedIn()) {
            return redirect()->to('dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
