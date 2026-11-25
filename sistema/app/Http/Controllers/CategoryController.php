<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Las más recientes primero
        $categories = Category::latest()->get();
        return view('settings.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50|unique:categories,name',
            'description' => 'nullable|max:255',
        ]);

        Category::create($validated);

        return to_route('categories.index')->with('ok', 'Categoría registrada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('settings.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:50',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'description' => 'nullable|max:255',
        ]);

        $category->update($validated);

        return to_route('categories.index')->with('ok', 'Categoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // medicines.category_id tiene restrictOnDelete(): se avisa antes de que MySQL lance el error 1451
        if ($category->medicines()->exists()) {
            return to_route('categories.index')->with('error', 'No se puede eliminar: la categoría tiene medicamentos asociados');
        }

        $category->delete();

        return to_route('categories.index')->with('ok', 'Categoría eliminada correctamente');
    }
}