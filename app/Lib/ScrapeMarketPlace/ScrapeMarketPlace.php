<?php

namespace App\Lib\ScrapeMarketPlace;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Web\Shopee;
use App\Lib\ScrapeMarketPlace\Web\Tokopedia;
use PharIo\Manifest\Url;

class ScrapeMarketPlace {

    static public function product($url)
    {
        $result = null;
        $host = parse_url($url, PHP_URL_HOST);
        if ($host == 'shopee.co.id') {
            $result = new Shopee($url);
        }

        if ($host == 'tokopedia.com' || $host == 'www.tokopedia.com') {
            $result = new Tokopedia($url);
        }   
        
        if (!$result) throw new MarketPlaceException('Marketplace tidak disupport');
       
        return $result->singleProduct();
    }

    static public function products($url)
    {
        $result = null;
        $host = parse_url($url, PHP_URL_HOST);
        if ($host == 'shopee.co.id') {
            $result = new Shopee($url);
        }
        
        if (!$result) throw new MarketPlaceException('Marketplace tidak di support!');
       
        return $result->multipleProduct();
    }

}