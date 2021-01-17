<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataTableController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('/{slug}.{productId}', [ProductController::class, 'single'])->name('product.single');
Route::get('/c/{slug}.{categoryId}', [CategoryController::class, 'single'])->name('category.single');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/order', [OrderController::class, 'store'])->name('order.make');
Route::get('/order/konfirmasi-pembayaran', [OrderController::class, 'konfirmasiBayar'])->name('order.konfirmasi');
Route::get('/order/lacak', [OrderController::class, 'lacak'])->name('order.lacak');
Route::get('/order/sukses/{invoiceId}', [OrderController::class, 'sukses'])->name('order.sukses');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// auth routes
Route::group(['prefix' => 'app-auth'], function() {
    Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
});

// admin routes 
Route::group(['prefix' => 'app-panel', 'middleware' => ['auth']], function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'data-table'], function() {
        Route::get('/product',[DataTableController::class, 'products'])->name('dt.product');
    });
    Route::resource('product', AdminProductController::class);
});

// test routes
Route::get('/test/wablas', [TestController::class, 'wablas']);
