@extends('template.administrador')
@section('title', 'Medicamentos')
@section('name_section', 'Medicamentos')
@section('description_section', 'Inventario y catálogo de medicamentos')

@section('content')
<div class="card border-0 shadow-sm p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Listado de Medicamentos</h6>
    <a href="{{ route('medicines.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Nuevo Medicamento</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Imagen</th>
          <th>Medicamento</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Vencimiento</th>
          <th>Estado</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($medicines as $item)
        <tr>
          <td>
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="rounded" style="width:45px;height:45px;object-fit:cover">
            @else
              <span class="badge bg-light text-secondary">Sin foto</span>
            @endif
          </td>
          <td>
            <div class="fw-semibold">{{ $item->name }}</div>
            <small class="text-muted">{{ $item->generic_name }} {{ $item->presentation ? '• ' . $item->presentation : '' }}</small>
          </td>
          <td>{{ $item->category->name ?? '-' }}</td>
          <td>S/ {{ number_format($item->price, 2) }}</td>
          <td>
            <span class="badge {{ $item->stock <= 5 ? 'bg-danger' : 'bg-primary' }}">{{ $item->stock }}</span>
          </td>
          <td>{{ $item->expiration_date ?? '-' }}</td>
          <td>
            <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">
              {{ $item->status ? 'Activo' : 'Inactivo' }}
            </span>
          </td>
          <td class="text-end">
            <a href="{{ route('medicines.edit', $item) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('medicines.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar medicamento?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted">No hay medicamentos registrados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
