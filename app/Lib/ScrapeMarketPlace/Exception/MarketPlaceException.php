<?php

namespace App\Lib\ScrapeMarketPlace\Exception;

class MarketPlaceException extends \Exception {

    public function __construct($message = "", $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}