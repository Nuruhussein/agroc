<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produce;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{ public function index(Request $request)
    {
        $search = $request->input('search', '');

        \Log::info('Search request:', ['search' => $search]);

        $orders = Order::with('produce.user', 'buyer')
            ->when($search, function ($query, $search) {
                $query->whereHas('produce', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                })
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('delivery_status', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        \Log::info('Search response:', ['order_count' => count($orders)]);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }
    public function create()
{
    // $produce = $produce->load('category'); // Eager-load the category relationship

    return inertia('Orders/Create', [
    'produce' => Produce::all(),
    ]);
}
    
    public function store(Request $request)
    {
        $request->validate([
            'produce_id' => 'required|exists:produce,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Order::create([
            'buyer_id' => Auth::id(),
            'produce_id' => $request->produce_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
            'delivery_status' => 'pending',
        ]);

        return redirect()->route('orders.index');
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->only(['status', 'delivery_status']));
        return redirect()->route('orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
    public function show(Order $order)
    {
        return Inertia::render('Orders/Show', [
            'order' => $order->load('produce.user'),
        ]);
    }
}
