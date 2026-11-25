@extends('template.administrador')
@section('title', 'Ventas')
@section('name_section', 'Ventas')
@section('description_section', 'Historial de ventas realizadas')

@section('content')
<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Listado de Ventas</h6>
    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Nueva Venta</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Comprobante</th>
          <th>Cliente</th>
          <th>Vendedor</th>
          <th>Total</th>
          <th>Fecha</th>
          <th class="text-end">Detalle</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sales as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td><span class="badge bg-dark">{{ $item->voucher_type }}</span> {{ $item->voucher_number }}</td>
          <td class="fw-semibold">{{ $item->customer->name ?? '-' }}</td>
          <td>{{ $item->user->name ?? '-' }}</td>
          <td class="fw-bold text-success">S/ {{ number_format($item->total, 2) }}</td>
          <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
          <td class="text-end">
            <a href="{{ route('sales.show', $item) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i> Ver</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">No hay ventas registradas.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
