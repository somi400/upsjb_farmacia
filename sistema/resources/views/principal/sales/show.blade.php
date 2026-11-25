@extends('template.administrador')
@section('title', 'Detalle de Venta')
@section('name_section', 'Detalle de Venta')
@section('description_section', 'Comprobante ' . $sale->voucher_number)

@section('content')
<div class="card border-0 shadow-sm p-4 col-md-9">
  <div class="row mb-3">
    <div class="col-md-6">
      <p class="mb-1"><strong>Comprobante:</strong> {{ $sale->voucher_type }} {{ $sale->voucher_number }}</p>
      <p class="mb-1"><strong>Cliente:</strong> {{ $sale->customer->name }} ({{ $sale->customer->dni }})</p>
    </div>
    <div class="col-md-6 text-md-end">
      <p class="mb-1"><strong>Vendedor:</strong> {{ $sale->user->name }}</p>
      <p class="mb-1"><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>
  </div>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Medicamento</th>
        <th>Precio Unit.</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sale->details as $det)
      <tr>
        <td>{{ $det->medicine->name ?? '-' }}</td>
        <td>S/ {{ number_format($det->unit_price, 2) }}</td>
        <td>{{ $det->quantity }}</td>
        <td>S/ {{ number_format($det->subtotal, 2) }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">TOTAL</th>
        <th class="text-success">S/ {{ number_format($sale->total, 2) }}</th>
      </tr>
    </tfoot>
  </table>

  <div class="mt-3">
    <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Volver al listado</a>
  </div>
</div>
@endsection
