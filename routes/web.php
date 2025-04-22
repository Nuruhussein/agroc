<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProduceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PriceGuideController;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('produce', ProduceController::class);
Route::resource('orders', OrderController::class);
Route::resource('messages', MessageController::class);
Route::resource('ratings', RatingController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('price-guides', PriceGuideController::class)->only(['index']);
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
