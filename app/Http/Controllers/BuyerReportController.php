<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BuyerReportController extends Controller
{
 public function create(OrderItem $orderItem)
{
    // Ensure relationships are loaded
    $orderItem->loadMissing(['order', 'produce.user']);

    // // Protect against missing relations
    if (!$orderItem->order || $orderItem->order->buyer_id !== Auth::id()) {
        abort(403, 'Unauthorized access to this order.');
    }

    if ($orderItem->delivery_status !== 'delivered') {
        abort(403, 'Item not marked as delivered.');
    }

    // Check if already reported
    if (Report::where('buyer_id', Auth::id())
              ->where('order_item_id', $orderItem->id)
              ->exists()) {
        return redirect()->back()->with('error', 'You have already reported this item.');
    }

    return Inertia::render('Buyer/ReportFarmer', [
        'orderItem' => [
            'id' => $orderItem->id,
            'produce_name' => $orderItem->produce->name,
            'farmer_name' => $orderItem->produce->user->name,
        ],
    ]);
}

   public function store(Request $request, OrderItem $orderItem)
{
    $orderItem->loadMissing(['order', 'produce.user']);

    if (!$orderItem->order || $orderItem->order->buyer_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    if ($orderItem->delivery_status !== 'delivered') {
        abort(403, 'Cannot report an undelivered item.');
    }

    $request->validate([
        'reason' => 'required|string|max:1000',
    ]);

    if (Report::where('buyer_id', Auth::id())
              ->where('order_item_id', $orderItem->id)
              ->exists()) {
        return redirect()->back()->with('error', 'You have already reported this item.');
    }

    Report::create([
        'buyer_id' => Auth::id(),
        'farmer_id' => $orderItem->produce->user_id,
        'order_item_id' => $orderItem->id,
        'reason' => $request->reason,
        'status' => 'pending',
    ]);

    return redirect()->route('dashboard')->with('success', 'Report submitted successfully.');
}

}