<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapeMarketPlace\SingleProductRequest;
use App\Jobs\CreateProduct;
use App\Jobs\HandleBackgroundScrapeJob;
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
        $request->validate([
            'url_mp' => 'required',
        ]);

        HandleBackgroundScrapeJob::dispatch((object) $request->all(), $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Sedang memproses.',
        ]);
    }
}
