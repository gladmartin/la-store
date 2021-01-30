<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class AutoUpdateProductController extends Controller
{
    private $key = '6l4DM412T1N';

    public function index(Request $request)
    {
        if ($request->key !== $this->key) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid key',
            ], 404);
        }

        $products = Product::where('url_sumber', '!=', null)->oldest()->take(30)->get();

        foreach ($products as $product) {
            UpdateProduct::dispatch($product);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sedang memproses..',
        ]);
    }
}
