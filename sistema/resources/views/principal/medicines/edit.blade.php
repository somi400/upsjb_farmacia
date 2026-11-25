@extends('template.administrador')
@section('title', 'Editar Medicamento')
@section('name_section', 'Editar Medicamento')
@section('description_section', 'Actualizar datos del medicamento')

@section('content')
<div class="card border-0 shadow-sm p-4 col-md-9">
  <form action="{{ route('medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Categoría *</label>
        <select name="category_id" class="form-select" required>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $medicine->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nombre comercial *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $medicine->name) }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nombre genérico</label>
        <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name', $medicine->generic_name) }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Presentación</label>
        <input type="text" name="presentation" class="form-control" value="{{ old('presentation', $medicine->presentation) }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Precio (S/) *</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $medicine->price) }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Stock *</label>
        <input type="number" min="0" name="stock" class="form-control" value="{{ old('stock', $medicine->stock) }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Fecha de vencimiento</label>
        <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date', $medicine->expiration_date) }}">
      </div>
      <div class="col-12">
        <label class="form-label">Cambiar imagen (opcional)</label>
        <input type="file" name="image" accept="image/*" class="form-control">
      </div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="status" id="status" {{ $medicine->status ? 'checked' : '' }}>
          <label class="form-check-label" for="status">Activo</label>
        </div>
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
@endsection
