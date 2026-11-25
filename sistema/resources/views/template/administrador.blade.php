<!doctype html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FARM SJB | @yield('title', 'Sistema de Venta de Medicamentos')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="https://jsdelivr.net">
  @stack('styles')
</head>

<body>

<div id="app-wrapper" class="d-flex">

  @include('partials.sidebar')

  <div class="main-wrapper d-flex flex-column flex-grow-1 overflow-hidden">
    @include('partials.header')

    <main class="app-content flex-grow-1 overflow-y-auto p-3 p-lg-4">
      <div class="container-fluid p-0">
        <div class="d-flex align-items-center justify-content-between flex-column flex-sm-row gap-2 mb-4">
          <p class="text-secondary mb-0">@yield('description_section', 'Panel de control')</p>

          <nav aria-label="Ruta de navegación">
            <ol class="breadcrumb mb-0 small">
              <li class="breadcrumb-item"><span>Inicio</span></li>
              <li class="breadcrumb-item text-muted fw-medium">@yield('name_section', 'Dashboard')</li>
            </ol>
          </nav>
        </div>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @yield('content')

      </div>
    </main>
  </div>
</div>

@include('partials.modal-logout')

<script src="https://jquery.com"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
