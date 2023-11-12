<?php

namespace App\Core\Routing;

use App\Core\Request;
use App\Core\Routing\Route;


class Router
{
    private $request;
    private $routes;
    private $currentRoute;


    public function __construct()
    {
        $this->request = new Request;
        $this->routes = Route::routes();
        $this->currentRoute = $this->findRoute($this->request) ?? null;
    }
    public function findRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if (!in_array($request->getMethod(), $route['method'])) {
                continue;
            }

            if ($this->regex_matched($route)) {
                return $route;
            }
        }
        return null;
    }

    function regex_matched($route)
    {
        global $request;
        $pattern = "/^" . str_replace(['/', '{', '}'], ['\/', '(?<', '>[-%\w]+)'], $route['uri']) . "$|\/$/";
        $result = preg_match($pattern, $this->request->getUri(), $matches);

        if (!$result) {
            return false;
        }

        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $request->setParams($key, $value);
            }
        }

        return true;
    }

    function runMiddleware(array $route)
    {
        $middlewares = $route['middleware'];

        foreach ($middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();
            $middleware->handle();
        }
    }
    public function run()
    {
        if (is_null($this->currentRoute)) {
            $this->dispatch404();
        }

        if ($this->invalidRequest($this->request)) {
            $this->dispatch405();
            die("Invalid request");
        }

        if ($this->runMiddleware($this->currentRoute)) {
            $this->dispatch405();
            die("Invalid request");
        }

        $this->dispatch($this->currentRoute);
    }

    private function invalidRequest(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($request->getUri() == $route['uri']) {
                return !in_array($request->getMethod(), $route['method']);
            }
        }
    }
    private function dispatch405()
    {
        header("HTTP/1.0 405 Method Not Allowed");
        view("errors.405");
        die();
    }

    private function dispatch404()
    {
        header("HTTP/1.0 404 Not Found");
        view("errors.404");
        die();
    }

    private function dispatch(array $route)
    {
        $action = $route["action"];

        if (is_null($action) || empty($action)) {
            return false;
        }

        if (is_callable($action)) {
            $action();
        }

        if (is_string($action)) {
            $fractions = explode("@", $action);
            $controller =  "App\Controllers\\" . $fractions[0];
            $method = $fractions[1];
            $this->passRequest($controller, $method);
        }

        if (is_array($action)) {
            $controller = "App\Controllers\\" . $action[0];
            $method = $action[1];
            $this->passRequest($controller, $method);
        }
    }
    function passRequest(string $controller, string $method)
    {
        if (!class_exists($controller)) {
            throw new \Exception("class $controller does not exist");
        }

        $controller_object = new $controller();

        if (!method_exists($controller_object, $method)) {
            throw new \Exception("method $method does not exist");
        }

        $controller_object->$method();
    }
}
