<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
class BuyerDashboardController extends Controller
{
    
public function buyerDashboard()
{
    $user = Auth::user();

    if ($user->role !== 'buyer') {
        abort(403, 'Unauthorized.');
    }

    $orders = Order::where('buyer_id', $user->id)->with('items')->get();

    $totalOrders = $orders->count();
    $deliveredItems = $orders->flatMap->items->where('delivery_status', 'delivered')->sum('quantity');
    $pendingOrders = $orders->where('status', 'pending')->count();

    return inertia('Buyer/Dashboard', [
        'totalOrders' => $totalOrders,
        'deliveredItems' => $deliveredItems,
        'pendingOrders' => $pendingOrders,
    ]);
}


    
}