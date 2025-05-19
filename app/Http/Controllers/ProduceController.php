<?php
namespace App\Http\Controllers;

use App\Models\Produce;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProduceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = Produce::with('user', 'category');

        // Restrict farmers to their own produce
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $produce = $query->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Produce/Index', [
            'produce' => $produce,
            'filters' => [
                'search' => $search,
            ],
            'isAdmin' => Auth::user()->role === 'admin', // Pass admin status to frontend
        ]);
    }

    public function create()
    {
        return Inertia::render('Produce/Create', [
            'categories' => Category::all(),
        ]);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'location' => 'nullable|string|max:255',
        'farm_name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'original_price' => 'nullable|numeric|min:0',
        'discount' => 'nullable|numeric|min:0|max:100',
        'organic' => 'boolean',
        'quantity' => 'required|integer|min:1',
        'image' => 'nullable|image|max:2048',
    ]);

    try {
        $imagePath = 'default.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produce_images', 'public');
        }

        Produce::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'location' => $validated['location'] ?? null,
            'farm_name' => $validated['farm_name'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'discount' => $validated['discount'] ?? null,
            'organic' => $validated['organic'] ?? false,
            'quantity' => $validated['quantity'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('produce.index')
            ->with('success', 'Produce added successfully!');
    } catch (\Exception $e) {
        Log::error('Error creating produce: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to create produce. Please try again.']);
    }
}

 public function show(Produce $produce)
{
    // Restrict farmers to their own produce
    if (Auth::user()->role !== 'admin' && $produce->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    return Inertia::render('Produce/Show', [
        'produce' => $produce->load('user', 'category'),
        'isAdmin' => Auth::user()->role === 'admin',
    ]);
}

    public function edit(Produce $produce)
    {
        // Restrict farmers to their own produce
        if (Auth::user()->role !== 'admin' && $produce->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Produce/Edit', [
            'produce' => $produce,
            'categories' => Category::all(),
            'isAdmin' => Auth::user()->role === 'admin', // Pass admin status
        ]);
    }

    public function update(Request $request, Produce $produce)
    {
        // Restrict farmers to their own produce
        if (Auth::user()->role !== 'admin' && $produce->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $produce->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()
            ->route('produce.index')
            ->with('success', 'Produce updated successfully!');
    }

    public function destroy(Produce $produce)
    {
        // Restrict farmers to their own produce
        if (Auth::user()->role !== 'admin' && $produce->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $produce->delete();
        return redirect()
            ->route('produce.index')
            ->with('success', 'Produce deleted successfully!');
    }
}