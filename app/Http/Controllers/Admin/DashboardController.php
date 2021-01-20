<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Product::get('id')->count();
        $order = Order::get('id')->count();

        return view('admin.dashboard.index', compact('produk', 'order'));
    }
}
