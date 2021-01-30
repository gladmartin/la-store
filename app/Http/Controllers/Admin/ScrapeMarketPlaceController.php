<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapeMarketPlace\SingleProductRequest;
use App\Jobs\CreateProduct;
use App\Lib\ScrapeMarketPlace\ScrapeMarketPlace;
use Illuminate\Http\Request;

class ScrapeMarketPlaceController extends Controller
{

    public function index()
    {
        return view('admin.scrape.index');
    }


    public function single(SingleProductRequest $request)
    {
        $product = ScrapeMarketPlace::product($request->url, $request->persen, $request->tambah);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function multiple(SingleProductRequest $request)
    {
        $product = ScrapeMarketPlace::products($request->url);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function background(Request $request)
    {
        if ($request->is_toko) {
            try {
                $products = ScrapeMarketPlace::products($request->url_mp);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ]);
            }
            foreach ($products as $product) {
                $product = (object) $product;
                CreateProduct::dispatch($product->api_url, $request->tambah, $request->persen, $request->user());
            }
        } else {
            CreateProduct::dispatch($request->url_mp, $request->tambah, $request->persen, $request->user());
        }

        return response()->json([
            'success' => true,
            'message' => 'Sedang memproses.',
        ]);
    }
}
