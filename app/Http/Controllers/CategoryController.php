<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function single(string $slugCategory, int $categoryId)
    {
        $category = Category::where('slug', $slugCategory)->findOrFail($categoryId);
        $products = $category->products()->paginate(20);
        
        return view('site.category.single', compact('category', 'products'));
    }
}
