<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('category')->latest()->get();
        return view('principal.medicines.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('principal.medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:120',
            'generic_name' => 'nullable|string|max:120',
            'presentation' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($data);
        return redirect()->route('medicines.index')->with('success', 'Medicamento registrado correctamente.');
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::where('status', true)->get();
        return view('principal.medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:120',
            'generic_name' => 'nullable|string|max:120',
            'presentation' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image', 'status');
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);
        return redirect()->route('medicines.index')->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Medicamento eliminado.');
    }
}
