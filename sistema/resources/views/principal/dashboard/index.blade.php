@extends('template.administrador')

@section('title', 'Dashboard')
@section('name_section', 'Dashboard')
@section('description_section', 'Resumen general de la farmacia')

@section('content')
<div class="row g-3">
  <div class="col-md-3">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="text-secondary small">Categorías</h6>
      <h3 class="fw-bold mb-0">{{ \App\Models\Category::count() }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="text-secondary small">Medicamentos</h6>
      <h3 class="fw-bold mb-0">{{ \App\Models\Medicine::count() }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="text-secondary small">Clientes</h6>
      <h3 class="fw-bold mb-0">{{ \App\Models\Customer::count() }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm p-3">
      <h6 class="text-secondary small">Ventas</h6>
      <h3 class="fw-bold mb-0">{{ \App\Models\Sale::count() }}</h3>
    </div>
  </div>
</div>
@endsection
