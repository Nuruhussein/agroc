<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produce;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produce_id' => 'required|exists:produce,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        $produce = Produce::findOrFail($request->produce_id);

        $cartItem = Cart::where('user_id', $user->id)
            ->where('produce_id', $request->produce_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'produce_id' => $request->produce_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'produce_id' => 'required|exists:produce,id',
            'change' => 'required|integer|in:-1,1',
        ]);

        $user = $request->user();
        $cartItem = Cart::where('user_id', $user->id)
            ->where('produce_id', $request->produce_id)
            ->first();

        if ($cartItem) {
            if ($request->change === 1) {
                $cartItem->update(['quantity' => $cartItem->quantity + 1]);
                $message = 'Item quantity increased!';
            } else {
                if ($cartItem->quantity > 1) {
                    $cartItem->update(['quantity' => $cartItem->quantity - 1]);
                    $message = 'Item quantity reduced!';
                } else {
                    $cartItem->delete();
                    $message = 'Item removed from cart!';
                }
            }
            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function index()
    {
        $cartItems = Cart::with('produce')
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'produce_id' => $item->produce_id,
                    'name' => $item->produce->name,
                    'price' => number_format($item->produce->price, 2),
                    'quantity' => $item->quantity,
                    'imageSrc' => $item->produce->image_path ? asset('storage/' . $item->produce->image_path) : 'https://via.placeholder.com/150',
                    'imageAlt' => $item->produce->name . ' image',
                ];
            });

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'cartCount' => $cartItems->count(),
        ]);
    }
}