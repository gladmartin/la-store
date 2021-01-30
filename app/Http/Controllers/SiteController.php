<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $categories = Category::rootCategory()->latest()->take(20)->get();
        $produkTerlaris = Product::terlaris()->latest()->take(20)->get();
        $produkTerbaru = Product::latest()->paginate();

        return view('site.beranda', compact('categories', 'produkTerlaris', 'produkTerbaru'));
    }

    public function menuCat()
    {
        $cat = Category::rootCategory()->latest()->take(20)->get();

        $data = null;
        foreach ($cat as $item) {
            $data[] = [
                'name' => $item->name,
                'id' => $item->id,
                'slug' => $item->slug,
                'url' => route('category.single', [$item->slug, $item->id]),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
