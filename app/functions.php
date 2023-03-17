<?php

function dda($data, bool $die = true)
{
    if (!headers_sent()) {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: $origin");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        header('HTTP/1.1 500 Internal Server Error');
    }

    $output = $data && !is_string($data) && is_object($data) && method_exists($data, 'toArray') ? $data->toArray() : $data;
    if ($die) dd($output);
    dump($output);
}
