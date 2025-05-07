<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
            ],
            'quote' => [
                'message' => trim($message),
                'author' => trim($author),
            ],
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                ] : null,
            ],
            'cartItems' => $request->user() ? Cart::where('user_id', $request->user()->id)
                ->with('produce')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'produce_id' => $item->produce_id,
                        'name' => $item->produce->name,
                        'price' => $item->produce->price,
                        'quantity' => $item->quantity,
                        'imageSrc' => $item->produce->imageSrc,
                        'imageAlt' => $item->produce->imageAlt,
                    ];
                })->toArray() : [],
            'cartCount' => $request->user() ? Cart::where('user_id', $request->user()->id)->count() : 0,
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => !$request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}