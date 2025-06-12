<?php

namespace App\Http\Controllers;

use App\Models\PriceGuide;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PriceGuideController extends Controller
{

    public function priceGuideIndex()
{
    $categories = PriceGuide::orderBy('category')->get();

    return Inertia::render('Admin/PriceGuide', [
        'categories' => $categories,
    ]);
}

public function updatePriceGuide(Request $request, PriceGuide $priceGuide)
{
    $request->validate([
        'base_price' => 'required|numeric|min:0',
    ]);

    $priceGuide->update([
        'base_price' => $request->base_price,
    ]);

    return redirect()->back()->with('success', 'Base price updated successfully.');
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PriceGuide $priceGuide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceGuide $priceGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceGuide $priceGuide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceGuide $priceGuide)
    {
        //
    }
}
