<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Category/Index', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:categories|max:255']);
        Category::create(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|unique:categories,name,'.$category->id.'|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
