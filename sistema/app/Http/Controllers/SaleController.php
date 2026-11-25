<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailSale;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'user'])->latest()->get();
        return view('principal.sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::where('status', true)->get();
        $users = User::where('status', true)->get();
        $medicines = Medicine::where('status', true)->where('stock', '>', 0)->get();
        return view('principal.sales.create', compact('customers', 'users', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'voucher_type' => 'required|in:Boleta,Factura',
            'voucher_number' => 'required|string|max:30|unique:sales,voucher_number',
            'medicine_id' => 'required|array|min:1',
            'medicine_id.*' => 'required|exists:medicines,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $total = 0;
                $items = [];

                foreach ($request->medicine_id as $i => $medId) {
                    $medicine = Medicine::lockForUpdate()->findOrFail($medId);
                    $qty = (int) $request->quantity[$i];

                    if ($medicine->stock < $qty) {
                        throw new \Exception("Stock insuficiente para {$medicine->name} (disponible: {$medicine->stock}).");
                    }

                    $subtotal = $medicine->price * $qty;
                    $total += $subtotal;

                    $items[] = [
                        'medicine' => $medicine,
                        'quantity' => $qty,
                        'unit_price' => $medicine->price,
                        'subtotal' => $subtotal,
                    ];
                }

                $sale = Sale::create([
                    'user_id' => $request->user_id,
                    'customer_id' => $request->customer_id,
                    'voucher_type' => $request->voucher_type,
                    'voucher_number' => $request->voucher_number,
                    'total' => $total,
                    'status' => 'Completada',
                ]);

                foreach ($items as $item) {
                    DetailSale::create([
                        'sale_id' => $sale->id,
                        'medicine_id' => $item['medicine']->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $item['medicine']->decrement('stock', $item['quantity']);
                }
            });

            return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'user', 'details.medicine']);
        return view('principal.sales.show', compact('sale'));
    }
}
