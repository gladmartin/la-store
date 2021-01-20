<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/province', [RajaOngkirController::class, 'province']);
Route::get('/city', [RajaOngkirController::class, 'city']);
Route::get('/subdistrict', [RajaOngkirController::class, 'subdistrict']);
Route::get('/ongkir', [RajaOngkirController::class, 'ongkir']);

Route::get('/lacak-order/{invoice}', [OrderController::class, 'lacakJson']);