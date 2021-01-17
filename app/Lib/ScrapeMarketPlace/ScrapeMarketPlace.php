<?php

namespace App\Lib\ScrapeMarketPlace;

use App\Lib\ScrapeMarketPlace\Web\Shopee;

class ScrapeMarketPlace {

    static public function product($url)
    {
        $result = null;
        $host = parse_url($url, PHP_URL_HOST);
        if ($host == 'shopee.co.id') {
            $result = new Shopee($url);
        }        
       
        return $result->singleProduct();
    }

}