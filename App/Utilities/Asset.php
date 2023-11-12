<?php

namespace App\Utilities;

class Asset
{
    public static function __callStatic($method, $args)
    {
        if (in_array($method, ['css', 'js', 'image', 'fonts'])) {
            return $_ENV['HOST_ADDR'] . 'public/' . $method . '/' . $args[0];
        } else {
            throw new \BadMethodCallException("Method $method does not exist.");
        }
    }
}
