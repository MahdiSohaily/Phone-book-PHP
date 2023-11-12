<?php

namespace App\Core;

class Request
{
    private $params;
    private $route_params;
    private $method;
    private $uri;
    private $agent;
    private $ip;

    function __construct()
    {
        $this->params = $_REQUEST;
        $this->agent = $_SERVER["HTTP_USER_AGENT"];
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->uri = strtok($_SERVER["REQUEST_URI"], '?');
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams($key, $value = null)
    {
        $this->route_params[$key] = $value;
    }

    public function getRouteParams(): array
    {
        return $this->route_params;
    }

    public function getRouteParam($key): string
    {
        return $this->route_params[$key];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->uri;
    }

    public function getAgent(): string
    {
        return $this->agent;
    }

    public function getIp(): string
    {
        return $this->ip;
    }
    public function getUri(): string
    {
        return $this->uri;
    }
}
