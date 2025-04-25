<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProduceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PriceGuideController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MarketController;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


// Route::get('/markateplace', function () {
//     return Inertia::render('markateplace/Index');
// })->name('markateplace');
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('produce', ProduceController::class);
Route::resource('orders', OrderController::class);
Route::resource('categories', CategoryController::class);

Route::resource('messages', MessageController::class);
Route::resource('ratings', RatingController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('price-guides', PriceGuideController::class)->only(['index']);

Route::get('/markateplace', [MarketController::class, 'index'])->name('markateplace');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
