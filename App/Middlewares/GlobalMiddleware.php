<?php

namespace App\Middlewares;

use App\Middlewares\Contracts\MiddlewareInterface;

class GlobalMiddleware implements MiddlewareInterface
{

    public function handle()
    {
        $this->sanitizeString();
    }

    private function sanitizeString()
    {
        foreach ($_REQUEST as $key => $value) {
            $_REQUEST[$key] = xss_clean($value);
        }
    }
}
