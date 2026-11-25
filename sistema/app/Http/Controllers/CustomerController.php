<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('principal.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('principal.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:15|unique:customers,dni',
            'name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:120',
            'address' => 'nullable|string|max:200',
        ]);

        Customer::create($request->only('dni', 'name', 'phone', 'email', 'address'));
        return redirect()->route('customers.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(Customer $customer)
    {
        return view('principal.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'dni' => 'required|string|max:15|unique:customers,dni,' . $customer->id,
            'name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:120',
            'address' => 'nullable|string|max:200',
        ]);

        $customer->update([
            'dni' => $request->dni,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->has('status'),
        ]);

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->sales()->exists()) {
            return back()->with('error', 'No se puede eliminar: tiene ventas registradas.');
        }
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Cliente eliminado.');
    }
}
