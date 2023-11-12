<?php

namespace App\Core\Routing;

class Route
{
    private static $routes = [];
    public static function add($method, $uri, $action = null, $middleware = [])
    {
        $method = is_array($method) ? $method : [$method];
        array_push(self::$routes, ['method' => $method, 'uri' => $uri, 'action' => $action, 'middleware' => $middleware]);
    }

    public static function routes()
    {
        return self::$routes;
    }
 
    public static function get($uri, $action, $middleware = [])
    {
        self::add('get', $uri, $action, $middleware);
    }

    public static function post($uri, $action, $middleware = [])
    {
        self::add('post', $uri, $action, $middleware);
    }
 
    public static function put($uri, $action, $middleware = [])
    {
        self::add('put', $uri, $action, $middleware);
    }

    public static function patch($uri, $action, $middleware = [])
    {
        self::add('patch', $uri, $action, $middleware);
    }

    public static function delete($uri, $action, $middleware = [])
    {
        self::add('delete', $uri, $action, $middleware);
    }
}
