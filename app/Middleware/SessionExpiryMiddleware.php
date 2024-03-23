<?php

namespace App\Middleware;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Middleware\Middleware;

class SessionExpiryMiddleware extends Middleware
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        if (!$session->isValid()) {
            return redirect()->to(base_url('/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
