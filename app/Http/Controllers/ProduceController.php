<?php
namespace App\Http\Controllers;

use App\Models\Produce;
use Illuminate\Http\Request;
use Inertia\Inertia;
// use App\Models\Produce;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProduceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $produce = Produce::with('user','category')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Produce/Index', [
            'produce' => $produce,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        // return Inertia::render('Produce/Create');
        // In your controller
return Inertia::render('Produce/Create', [
    'categories' => Category::all(), // or whatever your category model is
]);
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
    ]);
   
    try {
        Produce::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'image_path' => 'default.jpg',
        ]);

        return redirect()
            ->route('produce.index')
            ->with('success', 'Produce added successfully!');
    } catch (\Exception $e) {
        return back()->withErrors(['category_id' => 'Failed to create produce. Please ensure the selected category is valid.']);
    }
}
    public function edit(Produce $produce)
    {
        return Inertia::render('Produce/Edit', ['produce' => $produce]);
    }

    public function update(Request $request, Produce $produce)
    {
        $produce->update($request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]));

        return redirect()->route('produce.index');
    }

    public function destroy(Produce $produce)
    {
        $produce->delete();
        return redirect()->route('produce.index');
    }
    public function show(Produce $produce)
{
    return Inertia::render('Produce/Show', ['produce' => $produce->load('user','category')]);
}
}