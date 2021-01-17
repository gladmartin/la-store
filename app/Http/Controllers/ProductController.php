<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function single($slugProduct, $productId)
    {
        $product = Product::where('slug', $slugProduct)->findOrFail($productId);
        
        return view('site.product.single', compact('product'));
    }
}
