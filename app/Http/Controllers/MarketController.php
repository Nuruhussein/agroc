<?php

namespace App\Http\Controllers;

use App\Models\Produce;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Produce::query()
            ->with('category')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category !== 'All') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Filter organic only
        if ($request->boolean('organic')) {
            $query->where('organic', true);
        }

        // Search query
        if ($request->has('search') && !empty(trim($request->search))) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('farm_name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        return Inertia::render('markateplace/Index', [
            'products' => $query->paginate(12),
            'categories' => Category::pluck('name')->prepend('All'),
            'filters' => $request->only(['search', 'category', 'organic'])
        ]);
    }
}