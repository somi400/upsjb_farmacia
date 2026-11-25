<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->latest()->get();
        return view('principal.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Rol::where('status', true)->get();
        return view('principal.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:120',
            'dni' => 'required|string|max:15|unique:users,dni',
            'telefono' => 'nullable|string|max:20',
            'colegiatura' => 'nullable|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'rol_id' => $request->rol_id,
            'name' => $request->name,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'colegiatura' => $request->colegiatura,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Rol::where('status', true)->get();
        return view('principal.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:120',
            'dni' => 'required|string|max:15|unique:users,dni,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'colegiatura' => 'nullable|string|max:30',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'rol_id' => $request->rol_id,
            'name' => $request->name,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'colegiatura' => $request->colegiatura,
            'email' => $request->email,
            'status' => $request->has('status'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->sales()->exists()) {
            return back()->with('error', 'No se puede eliminar: el usuario tiene ventas registradas.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }
}
