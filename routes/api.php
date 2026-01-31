<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Products (Admin Only)
    Route::middleware('role:admin')->apiResource('products', ProductController::class);

    // Orders
    Route::get('orders', [OrderController::class,'index']); // All orders
    Route::post('orders', [OrderController::class,'store']); // Client create order
    Route::patch('orders/{order}/status', [OrderController::class,'updateStatus']); // Admin / Delivery update status
});
