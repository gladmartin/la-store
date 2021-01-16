<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all(['id', 'name']);

        return view('site.shop.index', compact('categories'));
    }
}
