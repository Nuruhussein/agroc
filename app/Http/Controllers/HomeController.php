<?php

namespace App\Http\Controllers;

use App\Models\Produce;
use App\Models\Cart;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function featured()
    {
        $featuredProducts = Produce::with('category')
            ->where('organic', true)
            ->inRandomOrder()
            ->take(6)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'href' => route('produce.show', $product->id),
                    'imageSrc' => $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/150',
                    'imageAlt' => $product->name . ' image',
                    'price' => '$' . number_format($product->price, 2),
                    'category' => $product->category ? $product->category->name : 'N/A',
                ];
            });

        $cartItems = auth()->check()
            ? Cart::with('produce')
                ->where('user_id', auth()->id())
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'produce_id' => $item->produce_id,
                        'name' => $item->produce->name,
                        'price' => '$' . number_format($item->produce->price, 2),
                        'quantity' => $item->quantity,
                        'imageSrc' => $item->produce->image_path ? asset('storage/' . $item->produce->image_path) : 'https://via.placeholder.com/150',
                        'imageAlt' => $item->produce->name . ' image',
                    ];
                })
            : [];

        $cartCount = auth()->check() ? Cart::where('user_id', auth()->id())->count() : 0;

        return Inertia::render('Welcome', [
            'featuredProducts' => $featuredProducts,
            'cartItems' => $cartItems,
            'cartCount' => $cartCount,
        ]);
    }
}