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

Route::get('/', [HomeController::class, 'featured'])->name('home');

Route::get('/roletest', function () {
    return Inertia::render('test/roletest');
})->name('roletest');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['farmer'])->group(function () {
    Route::resource('produce', ProduceController::class)->except(['index', 'show']);
});
Route::resource('produce', ProduceController::class)->only(['index', 'show']);

Route::resource('orders', OrderController::class)->except(['store']);
Route::post('orders', [OrderController::class, 'store'])
    // ->middleware(['auth', 'buyer'])
    ->name('orders.store');

Route::resource('categories', CategoryController::class);

Route::resource('messages', MessageController::class);
Route::resource('ratings', RatingController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('price-guides', PriceGuideController::class)->only(['index']);

Route::get('/markateplace', [MarketController::class, 'index'])->name('markateplace');

Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';