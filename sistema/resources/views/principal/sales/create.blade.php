@extends('template.administrador')
@section('title', 'Nueva Venta')
@section('name_section', 'Nueva Venta')
@section('description_section', 'Registrar comprobante de venta')

@section('content')
<div class="card border-0 shadow-sm p-4">
  <form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Cliente *</label>
        <select name="customer_id" class="form-select" required>
          <option value="">Seleccione cliente...</option>
          @foreach($customers as $c)
            <option value="{{ $c->id }}">{{ $c->dni }} - {{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Vendedor *</label>
        <select name="user_id" class="form-select" required>
          @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Comprobante *</label>
        <select name="voucher_type" class="form-select" required>
          <option value="Boleta">Boleta</option>
          <option value="Factura">Factura</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">N° Comprobante *</label>
        <input type="text" name="voucher_number" class="form-control" value="B001-{{ str_pad(\App\Models\Sale::count() + 1, 6, '0', STR_PAD_LEFT) }}" required>
      </div>
    </div>

    <h6 class="fw-bold mb-2">Detalle de Medicamentos</h6>
    <div class="table-responsive mb-3">
      <table class="table table-bordered align-middle" id="detalleTabla">
        <thead class="table-light">
          <tr>
            <th>Medicamento</th>
            <th style="width:130px">Precio (S/)</th>
            <th style="width:120px">Cantidad</th>
            <th style="width:140px">Subtotal (S/)</th>
            <th style="width:60px"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <select name="medicine_id[]" class="form-select med-select" required onchange="actualizarFila(this)">
                <option value="" data-price="0">Seleccione medicamento...</option>
                @foreach($medicines as $m)
                  <option value="{{ $m->id }}" data-price="{{ $m->price }}">{{ $m->name }} (Stock: {{ $m->stock }})</option>
                @endforeach
              </select>
            </td>
            <td><input type="text" class="form-control precio-input" value="0.00" readonly></td>
            <td><input type="number" name="quantity[]" class="form-control cant-input" min="1" value="1" required oninput="actualizarFila(this)"></td>
            <td><input type="text" class="form-control sub-input" value="0.00" readonly></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)"><i class="bi bi-x-lg"></i></button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarFila()"><i class="bi bi-plus-lg"></i> Agregar producto</button>
      <h5 class="fw-bold mb-0">Total: S/ <span id="totalVenta">0.00</span></h5>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Registrar Venta</button>
      <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function actualizarFila(el) {
  const tr = el.closest('tr');
  const select = tr.querySelector('.med-select');
  const price = parseFloat(select.options[select.selectedIndex].dataset.price || 0);
  const qty = parseInt(tr.querySelector('.cant-input').value || 0);
  const sub = price * qty;
  tr.querySelector('.precio-input').value = price.toFixed(2);
  tr.querySelector('.sub-input').value = sub.toFixed(2);
  calcularTotal();
}

function calcularTotal() {
  let total = 0;
  document.querySelectorAll('.sub-input').forEach(inp => total += parseFloat(inp.value || 0));
  document.getElementById('totalVenta').textContent = total.toFixed(2);
}

function agregarFila() {
  const tbody = document.querySelector('#detalleTabla tbody');
  const clone = tbody.rows[0].cloneNode(true);
  clone.querySelector('.med-select').selectedIndex = 0;
  clone.querySelector('.precio-input').value = '0.00';
  clone.querySelector('.cant-input').value = 1;
  clone.querySelector('.sub-input').value = '0.00';
  tbody.appendChild(clone);
}

function eliminarFila(btn) {
  const tbody = document.querySelector('#detalleTabla tbody');
  if (tbody.rows.length > 1) {
    btn.closest('tr').remove();
    calcularTotal();
  }
}
</script>
@endpush
