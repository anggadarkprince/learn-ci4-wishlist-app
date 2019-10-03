<?php

namespace App\Filters;

use App\Models\AuthModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Throttle implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $throttler = Services::throttler();

        // Restrict an IP address to no more
        // than 1 request per second across the
        // entire site.
        if ($throttler->check(base64_encode($request->getIPAddress()), 60, MINUTE) === false) {
            return Services::response()->setStatusCode(429);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
