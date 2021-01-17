<?php

namespace App\Lib\ScrapeMarketPlace\Http;

use Illuminate\Support\Facades\Http;

class Request
{
    private static $responseAsJson = false;

    public static function get($url, array $headers = [], $parameter = null)
    {
        $response = Http::get($url, $parameter);
        return $response;
    }

    public static function post($url, array $headers = [], $body = null)
    {
        $response = Http::asForm()->post($url, $body);
        return $response;
    }
}
