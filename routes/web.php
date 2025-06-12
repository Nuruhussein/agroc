<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PriceGuideController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ChatController;


use App\Http\Controllers\FarmerOrderController;
Route::get('/', [HomeController::class, 'featured'])->name('home');

Route::get('/roletest', function () {
    return Inertia::render('test/roletest');
})->name('roletest');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/buyerdashboard', [BuyerDashboardController::class, 'buyerDashboard'])->name('buyer.dashboard');

    
     Route::get('/chat/conversations', [ChatController::class, 'conversations']);
 Route::get('/chat/{receiverId?}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
});
Route::middleware(['adminOrFarmer'])->group(function () {
    // Register all resource routes except 'update'
    Route::resource('produce', ProduceController::class)->except(['update']);
    // Define custom POST route for update
    Route::post('/produce/{produce}', [ProduceController::class, 'update'])->name('produce.update');
});



// Routes for Farmer's Order Management
Route::middleware(['auth', 'farmer'])->prefix('farmer')->group(function () {
    Route::get('/orders', [FarmerOrderController::class, 'index'])->name('farmer.orders.index');
    Route::get('/orders/{orderId}', [FarmerOrderController::class, 'show'])->name('farmer.orders.show');
Route::post('/orders/{orderId}/items/{orderItemId}/status', [FarmerOrderController::class, 'updateOrderItemStatus'])->name('farmer.orders.updateStatus');
});



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');


    Route::get('/price-guides', [PriceGuideController::class, 'priceGuideIndex'])->name('admin.price-guides.index');
    Route::post('/price-guides/{priceGuide}', [PriceGuideController::class, 'updatePriceGuide'])->name('admin.price-guides.update');

});

Route::resource('orders', OrderController::class)->except(['store']);
Route::post('orders', [OrderController::class, 'store'])
    // ->middleware(['auth', 'buyer'])
    ->name('orders.store');

Route::resource('categories', CategoryController::class);

Route::resource('messages', MessageController::class);
Route::resource('ratings', RatingController::class);
Route::resource('notifications', NotificationController::class);
// Route::resource('price-guides', PriceGuideController::class)->only(['index']);

Route::get('/markateplace', [MarketController::class, 'index'])->name('markateplace');

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';