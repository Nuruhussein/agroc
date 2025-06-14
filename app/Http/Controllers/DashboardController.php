<?php

namespace App\Http\Controllers;

use App\Models\Produce;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $data = ['role' => $role, 'breadcrumbs' => [['title' => 'Dashboard', 'href' => '/dashboard']]];

        if ($role === 'admin') {
            // Admin: Cards and charts
            $data['totalProducts'] = Produce::count();
            $data['latestProduce'] = Produce::select('name', 'price', 'unit', 'category_id', 'updated_at')
                ->with('category')
                ->orderBy('updated_at', 'desc')
                ->first();
            $data['priceTrend'] = Produce::where('created_at', '>=', now()->subDays(7))
                ->avg('price');
            $data['lineChartData'] = Produce::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG(price) as avg_price')
            )
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->map(function ($item) {
                    return [
                        'date' => $item->date,
                        'avg_price' => number_format($item->avg_price, 2),
                    ];
                });
            $data['barChartData'] = Produce::select(
                'categories.name as category_name',
                DB::raw('SUM(quantity) as total_quantity')
            )
                ->join('categories', 'produce.category_id', '=', 'categories.id')
                ->where('produce.created_at', '>=', now()->subDays(7))
                ->groupBy('categories.name')
                ->orderBy('total_quantity', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'category_name' => $item->category_name,
                        'total_quantity' => (int) $item->total_quantity,
                    ];
                });

            $data['totalProducts'] = $data['totalProducts'];
            $data['latestProduce'] = $data['latestProduce'] ? [
                'name' => $data['latestProduce']->name,
                'price' => $data['latestProduce']->price,
                'unit' => $data['latestProduce']->unit,
                'category_name' => $data['latestProduce']->category->name,
                'updated_at' => $data['latestProduce']->updated_at->toDateTimeString(),
            ] : null;
            $data['priceTrend'] = $data['priceTrend'] ? number_format($data['priceTrend'], 2) : null;
            $data['lineChartData'] = [
                'labels' => $data['lineChartData']->pluck('date')->map(function ($date) {
                    return \Carbon\Carbon::parse($date)->format('M d');
                }),
                'data' => $data['lineChartData']->pluck('avg_price'),
            ];
            $data['barChartData'] = [
                'labels' => $data['barChartData']->pluck('category_name'),
                'data' => $data['barChartData']->pluck('total_quantity'),
            ];
        } elseif ($role === 'buyer') {
            // Buyer: Cards and orders table
            $data['totalOrders'] = Order::where('buyer_id', $user->id)->count();
            $data['deliveredItems'] = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('buyer_id', $user->id);
            })
                ->where('delivery_status', 'delivered')
                ->sum('quantity');
            $data['pendingOrders'] = Order::where('buyer_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $data['orders'] = Order::where('buyer_id', $user->id)
                ->select('id', 'order_number', 'total_amount', 'status', 'created_at')
                ->withCount('items')
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->through(function ($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'total_amount' => number_format($order->total_amount, 2),
                        'status' => $order->status,
                        'items_count' => $order->items_count,
                        'created_at' => $order->created_at->toDateTimeString(),
                    ];
                });
        } elseif ($role === 'farmer') {
            // Farmer: Cards and produce table
            $data['totalOwnProducts'] = Produce::where('user_id', $user->id)->count();
            $data['latestProduct'] = Produce::select('name', 'price', 'unit', 'category_id', 'updated_at')
                ->where('user_id', $user->id)
                ->with('category')
                ->orderBy('updated_at', 'desc')
                ->first();
            $data['totalItemsOrdered'] = OrderItem::whereHas('produce', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum('quantity');
            $data['produce'] = Produce::where('user_id', $user->id)
                ->select('id', 'name', 'price', 'unit', 'quantity', 'category_id', 'updated_at')
                ->with('category')
                ->orderBy('updated_at', 'desc')
                ->paginate(5)
                ->through(function ($produce) {
                    return [
                        'id' => $produce->id,
                        'name' => $produce->name,
                        'category_name' => $produce->category->name,
                        'price' => $produce->price,
                        'unit' => $produce->unit,
                        'quantity' => $produce->quantity,
                        'updated_at' => $produce->updated_at->toDateTimeString(),
                    ];
                });

            $data['latestProduct'] = $data['latestProduct'] ? [
                'name' => $data['latestProduct']->name,
                'price' => $data['latestProduct']->price,
                'unit' => $data['latestProduct']->unit,
                'category_name' => $data['latestProduct']->category->name,
                'updated_at' => $data['latestProduct']->updated_at->toDateTimeString(),
            ] : null;
        }

        return Inertia::render('Dashboard', $data);
    }
}