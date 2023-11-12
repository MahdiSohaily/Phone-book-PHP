<?php

function site_url(string $url = ''): string
{
    return $_ENV['HOST_ADDR'] . $url;
}

function asset_url(string $url = ''): string
{
    return site_url('public/' . $url);
}


function view($path = '', $data = [])
{
    extract($data);

    $filePath = str_replace('.', '/', $path);

    $fullPath = BASE_PATH . "views/$filePath.php";
    include_once $fullPath;
}
