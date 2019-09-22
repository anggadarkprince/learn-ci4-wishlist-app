<?php

namespace App\Filters;

use App\Models\AuthModel;
use App\Models\LogModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Logger implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        if (AuthModel::isLoggedIn()) {
            $agent = $request->getUserAgent();
            
            $log = new LogModel();
            $log->insert([
                'event_type' => 'access',
                'event_access' => uri_string(),
                'data' => json_encode([
                    'host' => $request->uri->getHost(),
                    'path' => $request->uri->getPath(),
                    'query' => $request->uri->getQuery(),
                    'ip' => $request->getIPAddress(),
                    'platform' => $agent->getPlatform(),
                    'browser' => $agent->getBrowser(),
                    'is_mobile' => $agent->isMobile(),
                ]),
                'created_by' => AuthModel::loginData('id', 0),
            ]);
        }
    }
}
