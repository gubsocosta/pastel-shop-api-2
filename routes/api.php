<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products', ProductController::class);
Route::apiResource('customers', CustomerController::class);
Route::controller(OrderController::class)->group(function () {
    Route::post('/orders/{order}/products', 'attachProduct')->name('orders.attach-product');
    Route::delete('/orders/{order}/products/{product}', 'detachProduct')->name('orders.detach-product');
});
Route::apiResource('orders', OrderController::class)->except(['update']);
