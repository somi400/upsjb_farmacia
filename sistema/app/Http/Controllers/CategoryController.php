<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('principal.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('principal.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only('name', 'description'));
        return redirect()->route('categories.index')->with('success', 'Categoría registrada correctamente.');
    }

    public function edit(Category $category)
    {
        return view('principal.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->medicines()->exists()) {
            return back()->with('error', 'No se puede eliminar: tiene medicamentos asociados.');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada.');
    }
}
