<?php

namespace App\Lib\ScrapeMarketPlace\Http;

use Illuminate\Support\Facades\Http;

class Request
{
    private static $responseAsJson = false;

    public static function get($url, array $headers = [], $parameter = null)
    {
        $response = Http::withHeaders($headers)->get($url, $parameter);
        return $response;
    }

    public static function post($url, array $headers = [], $body = [])
    {
        $response = Http::withHeaders($headers)->post($url, $body);
        return $response;
    }
}
