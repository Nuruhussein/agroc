<?php
namespace App\Http\Controllers;

use App\Models\Produce;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProduceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $produce = Produce::with('user')
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
        return Inertia::render('Produce/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        Produce::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image_path' => $request->image_path ?? 'default.jpg',
        ]);

        return redirect()->route('produce.index');
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
    return Inertia::render('Produce/Show', ['produce' => $produce->load('user')]);
}
}