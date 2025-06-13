<?php
namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // Validate query parameters
        $request->validate([
            'search' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:100',
            'produce_min' => 'nullable|integer|min:0',
            'produce_max' => 'nullable|integer|min:0',
        ]);

        // Build query for farmers
        $query = User::select('id', 'name', 'profile_picture', 'region')
            ->where('role', 'farmer')
            ->withCount('produce');

        // Apply search filter (name or region)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('region', 'like', '%' . $search . '%');
            });
        }

        // Apply region filter
        if ($request->filled('region')) {
            $query->where('region', $request->input('region'));
        }

        // Apply produce count filter
        if ($request->filled('produce_min')) {
            $query->having('produce_count', '>=', $request->input('produce_min'));
        }
        if ($request->filled('produce_max')) {
            $query->having('produce_count', '<=', $request->input('produce_max'));
        }

        // Paginate results
        $farmers = $query->paginate(12)->withQueryString();

        // Get unique regions for filter dropdown
        $regions = User::where('role', 'farmer')
            ->whereNotNull('region')
            ->distinct()
            ->pluck('region')
            ->sort()
            ->values();

        return Inertia::render('Profiles/Index', [
            'farmers' => $farmers,
            'filters' => $request->only(['search', 'region', 'produce_min', 'produce_max']),
            'regions' => $regions,
        ]);
    }
}