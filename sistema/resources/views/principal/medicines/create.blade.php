@extends('template.administrador')
@section('title', 'Nuevo Medicamento')
@section('name_section', 'Nuevo Medicamento')
@section('description_section', 'Registrar medicamento en el inventario')

@section('content')
<div class="card border-0 shadow-sm p-4 col-md-9">
  <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Categoría *</label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
          <option value="">Seleccione...</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Nombre comercial *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Nombre genérico</label>
        <input type="text" name="generic_name" class="form-control" value="{{ old('generic_name') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Presentación (ej. Caja x 20 tab)</label>
        <input type="text" name="presentation" class="form-control" value="{{ old('presentation') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Precio (S/) *</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <label class="form-label">Stock inicial *</label>
        <input type="number" min="0" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-md-4">
        <label class="form-label">Fecha de vencimiento</label>
        <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date') }}">
      </div>
      <div class="col-12">
        <label class="form-label">Imagen del producto</label>
        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <div class="d-flex gap-2 mt-4">
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
@endsection
