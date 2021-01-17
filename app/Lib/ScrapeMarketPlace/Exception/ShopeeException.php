<?php

namespace App\Lib\ScrapeMarketPlace\Exception;

class ShopeeException extends MarketPlaceException {

    public function __construct($message = "", $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}