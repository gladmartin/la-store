<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function single(string $slugProduct, int $productId)
    {
        $product = Product::where('slug', $slugProduct)->findOrFail($productId);
        // dd($product->variasi);
        // $variasi = $product->models->unique('key');
        // dd($variasi);
        // dd('oke');
        return view('site.product.single', compact('product'));
    }
}
