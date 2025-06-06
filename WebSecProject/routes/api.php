<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::post('/cart/add', [CartController::class, 'addItem']);
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::put('/cart/update/{product_id}', [CartController::class, 'updateItem']);
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'removeItem']);

    // Route::post('/checkout', [CartController::class, 'checkout']);
    // Route::get('/orders', [CartController::class, 'index']);
    // Route::post('/orders/{id}/cancel', [CartController::class, 'cancel']);

    // Route::post('/orders/checkout', [OrderController::class, 'checkout']);
    // Route::get('/orders', [OrderController::class, 'index']);
    // // Route::get('/orders/{id}', [OrderController::class, 'showOrder']);
    // // Route::put('/orders/update-status/{id}', [OrderController::class, 'updateOrderStatus']);
    // Route::delete('/orders/{id}/cancel', [OrderController::class, 'cancel']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);

});
