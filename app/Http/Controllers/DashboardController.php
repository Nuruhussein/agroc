<?php

namespace App\Http\Controllers;

use App\Models\Produce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total products
        $totalProducts = Produce::count();

        // Latest produce listing
        $latestProduce = Produce::select('name', 'price', 'unit', 'category_id', 'updated_at')
            ->with('category')
            ->orderBy('updated_at', 'desc')
            ->first();

        // Price trend (average price over last 7 days)
        $priceTrend = Produce::where('created_at', '>=', now()->subDays(7))
            ->avg('price');

        // Chart data: Daily average prices for the last 7 days
        $chartData = Produce::select(
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

        return Inertia::render('Dashboard', [
            'totalProducts' => $totalProducts,
            'latestProduce' => $latestProduce ? [
                'name' => $latestProduce->name,
                'price' => $latestProduce->price,
                'unit' => $latestProduce->unit,
                'category_name' => $latestProduce->category->name,
                'updated_at' => $latestProduce->updated_at->toDateTimeString(),
            ] : null,
            'priceTrend' => $priceTrend ? number_format($priceTrend, 2) : null,
            'chartData' => [
                'labels' => $chartData->pluck('date')->map(function ($date) {
                    return \Carbon\Carbon::parse($date)->format('M d');
                }),
                'data' => $chartData->pluck('avg_price'),
            ],
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'href' => '/dashboard'],
            ],
        ]);
    }
}