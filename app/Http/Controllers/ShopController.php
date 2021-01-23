<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(['id', 'name']);
        $products = Product::query();
        $priceMin = (int) $request->price_min ?? null;
        $priceMax = (int) $request->price_max ?? null;

        if ($request->q) {
            $products->orWhere('title', 'like', '%' . $request->q . '%');
        }

        if ($request->category) {
            $products->where('category_id', $request->category);
        }

        if ($priceMin > 0 & $priceMax > 0) {
            $products->whereBetween('harga', [$priceMin, $priceMax]);
        } elseif ($request->price_min > 0) {
            $products->where('harga', '>=', $request->price_min);
        } elseif ($request->price_max > 0) {
            $products->where('harga', '<=', $request->price_max);
        }

        if ($request->price_order) {
            $orderHarga = $request->price_order == 'high_first' ? 'desc' : 'asc';
            $products->orderByRaw(DB::raw('harga+0 ' . $orderHarga));
        }
        // dd($products->toSql());
        $products = $products->latest()->paginate(20);

        return view('site.shop.index', compact('categories', 'products'));
    }
}
