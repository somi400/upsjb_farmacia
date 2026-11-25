<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::latest()->get();
        return view('principal.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('principal.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        Rol::create($request->only('name', 'description'));
        return redirect()->route('roles.index')->with('success', 'Rol registrado correctamente.');
    }

    public function edit(Rol $role)
    {
        return view('principal.roles.edit', compact('role'));
    }

    public function update(Request $request, Rol $role)
    {
        $request->validate([
            'name' => 'required|string|max:60|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Rol $role)
    {
        if ($role->users()->exists()) {
            return back()->with('error', 'No se puede eliminar: tiene usuarios asignados.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }
}
