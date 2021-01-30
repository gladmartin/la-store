<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function menu()
    {
        return response()->view('sitemap.menu')->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::all();

        return response()->view('sitemap.products', compact('products'))->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::all();

        return response()->view('sitemap.categories', compact('categories'))->header('Content-Type', 'text/xml');
    }

    public function posts()
    {
        $posts = Post::where('type', 'post')->where('status', 'published')->get();

        return response()->view('sitemap.posts', compact('posts'))->header('Content-Type', 'text/xml');
    }
}
