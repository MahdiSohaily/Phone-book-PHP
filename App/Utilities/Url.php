<?php

namespace App\Utilities;

class Url
{
    public  static function current(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function query_params(): array
    {
        $query = [];

        $parts = parse_url(self::current());

        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        return $query;
    }

    public static function current_route(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }
}
