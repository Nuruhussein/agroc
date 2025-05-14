<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BuyerMiddleware;
use App\Http\Middleware\FarmerMiddleware;
use App\Http\Middleware\AdminOrBuyerMiddleware;
use App\Http\Middleware\AdminOrBuyerOrFarmerMiddleware;
use App\Http\Middleware\AdminOrFarmerMiddleware;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Cookie configuration
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        // Global middleware
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // Register route middleware (alias)
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'farmer' => FarmerMiddleware::class,
            'buyer' => BuyerMiddleware::class,
            'adminOrFarmer' => \App\Http\Middleware\AdminOrFarmerMiddleware::class,
            'adminOrBuyer' => \App\Http\Middleware\AdminOrBuyerMiddleware::class,
            'adminOrBuyerOrFarmer' => \App\Http\Middleware\AdminOrBuyerOrFarmerMiddleware::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration
    })->create();