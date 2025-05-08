<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.produce', 'buyer'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return inertia('Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produce_id' => 'required|exists:produce,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string'
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        return DB::transaction(function () use ($request) {
            $order = Order::create([
                'buyer_id' => Auth::id(),
                'total_amount' => 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address
            ]);

            $totalAmount = 0;

            foreach ($request->items as $item) {
                $produce = Produce::findOrFail($item['produce_id']);
                $itemTotal = $produce->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'produce_id' => $item['produce_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $produce->price,
                    'total_price' => $itemTotal,
                ]);

                $totalAmount += $itemTotal;
            }

            $order->update(['total_amount' => $totalAmount]);

            // Clear the cart
            if ($request->has('clear_cart') && $request->clear_cart) {
                // Implement your cart clearing logic here
                Cart::where('user_id', Auth::id())->delete();
            }

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        });
    }

    public function show(Order $order)
    {
        $order->load(['items.produce', 'buyer']);

        return inertia('Orders/Show', [
            'order' => $order
        ]);
    }
    
}