<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function single($slugProduct, $productId)
    {
        $product = Product::where('slug', $slugProduct)->findOrFail($productId);
        $relatedProducts = $product->category->products()->where('id', '!=', $product->id)->latest()->take(20)->get();
        $pesanWaFloatingButton = 'Hai Kak mau tanya tentang '. $product->title .' (' . url()->current() .')';
        
        return view('site.product.single', compact('product', 'relatedProducts', 'pesanWaFloatingButton'));
    }
}
