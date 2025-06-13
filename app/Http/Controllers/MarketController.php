<?php

namespace App\Http\Controllers;

use App\Models\Produce;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Produce::query()
            ->with('category')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc');

        if ($request->has('category') && $request->category !== 'All') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->boolean('organic')) {
            $query->where('organic', true);
        }

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

    public function show(Produce $produce)
    {
        return Inertia::render('markateplace/Show', [
            'produce' => $produce->load('user', 'category'),
            'isAdmin' => Auth::user()->role === 'admin',
        ]);
    }

    public function userProfile(User $user, Request $request)
    {
        $query = Produce::query()
            ->where('user_id', $user->id)
            ->where('quantity', '>', 0)
            ->with('category', 'user')
            ->orderBy('created_at', 'desc');

        return Inertia::render('markateplace/UserProfile', [
            'user' => $user->only('id', 'name', 'email', 'phone', 'region', 'role', 'profile_picture', 'farm_name'),
            'products' => $query->paginate(12),
        ]);
    }
}