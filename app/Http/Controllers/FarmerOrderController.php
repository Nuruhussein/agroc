<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Mail\DeliveryStatusUpdated;
use Illuminate\Support\Facades\Mail;
class FarmerOrderController extends Controller
{
  public function index()
{
    $user = Auth::user();
    $query = Order::with(['items.produce.user', 'buyer'])->latest();

    if ($user->role !== 'admin') {
        // For farmers, filter orders where their produce is included
        $query->whereHas('items.produce', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    $orders = $query->get()->map(function ($order) use ($user) {
        // Calculate total and delivered quantities for the farmer's produce only
        $order->total_quantity = $order->items
            ->where('produce.user_id', $user->id)
            ->sum('quantity');
        $order->delivered_quantity = $order->items
            ->where('produce.user_id', $user->id)
            ->where('delivery_status', 'delivered')
            ->sum('quantity');
        return $order;
    });

    return inertia('Farmer/Orders/Index', [
        'orders' => $orders,
    ]);
}


    public function show($orderId)
    {
        $user = Auth::user();
        if ($user->role !== 'farmer') {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::with(['items.produce', 'buyer'])->findOrFail($orderId);
        $farmerItems = $order->items->filter(fn($item) => $item->produce->user_id === $user->id)->values();

        return inertia('Farmer/Orders/Show', [
            'order' => $order,
            'items' => $farmerItems,
        ]);
    }
    public function updateOrderItemStatus(Request $request, $orderId, $orderItemId)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,shipped,delivered',
        ]);

        $user = Auth::user();
        $orderItem = OrderItem::findOrFail($orderItemId);
        $order = $orderItem->order;

        if ($order->id !== (int) $orderId || $orderItem->produce->user_id !== $user->id) {
            return redirect()->route('farmer.orders.show', $orderId)
                ->withErrors(['delivery_status' => 'Unauthorized to update this item.'])
                ->with('status', 403);
        }

        try {
            $orderItem->update(['delivery_status' => $request->delivery_status]);

            if ($order->items->every(fn($item) => $item->delivery_status === 'delivered')) {
                $order->update(['status' => 'completed']);
            }
  // ✅ Send email if the item was marked as delivered
        if ($request->delivery_status === 'delivered') {
            Mail::to($order->buyer->email)->send(new DeliveryStatusUpdated($orderItem));
            // Mail::to('weddihaji@gmail.com')->send(new DeliveryStatusUpdated($orderItem));


        }

            return redirect()->route('farmer.orders.show', $orderId)
                ->with('success', 'Status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('farmer.orders.show', $orderId)
                ->withErrors(['delivery_status' => 'Update failed: ' . $e->getMessage()])
                ->with('status', 500);
        }
    }
}