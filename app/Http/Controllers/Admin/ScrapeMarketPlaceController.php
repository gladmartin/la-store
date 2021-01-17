<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapeMarketPlace\SingleProductRequest;
use App\Lib\ScrapeMarketPlace\ScrapeMarketPlace;
use Illuminate\Http\Request;

class ScrapeMarketPlaceController extends Controller
{
    public function single(SingleProductRequest $request)
    {
        // $url = 'https://shopee.co.id/AMD-Athlon-3000G-(Radeon-Vega-3)-3.5Ghz-AM4-i.312453948.7755235377';
        $product = ScrapeMarketPlace::product($request->url);
        
        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }
}
