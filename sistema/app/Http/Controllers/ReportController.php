<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $request->validate([
            'from'        => 'nullable|date',
            'to'          => 'nullable|date|after_or_equal:from',
            'customer_id' => 'nullable|exists:customers,id',
            'user_id'     => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to', now()->toDateString());

        $sales = Sale::with(['customer', 'user'])
            ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->when($request->customer_id, fn ($q, $id) => $q->where('customer_id', $id))
            ->when($request->user_id, fn ($q, $id) => $q->where('user_id', $id))
            ->when($request->category_id, fn ($q, $id) =>
                $q->whereHas('details.medicine', fn ($m) => $m->where('category_id', $id)))
            ->orderBy('date')
            ->get();

        $summary = [
            'count'   => $sales->count(),
            'total'   => $sales->sum('total'),
            'igv'     => $sales->sum('igv'),
            'average' => $sales->avg('total') ?? 0,
        ];

        $chart = $sales->groupBy(fn ($sale) => $sale->date->format('d/m'))
            ->map(fn ($group) => round($group->sum('total'), 2));

        $customers  = Customer::orderBy('name')->get();
        $users      = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('principal.reports.sales', compact(
            'sales', 'summary', 'chart', 'from', 'to', 'customers', 'users', 'categories'
        ));
    }
}
