<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataTableController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ScrapeMarketPlaceController;
use App\Http\Controllers\Admin\SettingController;
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
Route::post('/order/konfirmasi-pembayaran/store', [OrderController::class, 'storeKonfirmasiBayar'])->name('order.konfirmasi.store');
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
    
    // data table
    Route::group(['prefix' => 'data-table'], function() {
        Route::get('/product',[DataTableController::class, 'products'])->name('dt.product');
        Route::get('/order/{status?}',[DataTableController::class, 'order'])->name('dt.order');
        Route::get('/delivery',[DataTableController::class, 'delivery'])->name('dt.delivery');
    });
    Route::resource('product', AdminProductController::class);
    
    // scrape marketplace
    Route::get('/scrape-mp', [ScrapeMarketPlaceController::class, 'index'])->name('scrape-mp.index');
    Route::get('/scrape-mp/single', [ScrapeMarketPlaceController::class, 'single'])->name('scrape-mp.single');
    Route::get('/scrape-mp/multiple', [ScrapeMarketPlaceController::class, 'multiple'])->name('scrape-mp.multiple');

    // order 
    Route::get('order/{order}/konfirmasi-bayar', [AdminOrderController::class, 'konfirmasiBayar'])->name('order.konfirmasi-bayar');
    Route::get('order/{order}/sampai', [AdminOrderController::class, 'sampai'])->name('order.sampai');
    Route::resource('order', AdminOrderController::class);

    //delivery
    Route::post('delivery/{delivery}/store-detail', [DeliveryController::class, 'storeDetail'])->name('delivery.store.detail');
    Route::get('delivery/{deliveryDetail}/delete-detail', [DeliveryController::class, 'deleteDetail'])->name('delivery.delete.detail');
    Route::resource('delivery', DeliveryController::class);
    
    // account
    Route::get('account', [AccountController::class, 'index'])->name('account.index');
    Route::put('account', [AccountController::class, 'update'])->name('account.update');

    // setting web
    Route::get('setting/web', [SettingController::class, 'web'])->name('setting.web');
    

});

// test routes
Route::get('/test/wablas', [TestController::class, 'wablas']);
Route::get('/test', [TestController::class, 'random']);
