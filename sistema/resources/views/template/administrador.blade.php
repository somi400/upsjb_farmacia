<!doctype html>
<html lang="es" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="San Juan - Sistema de Venta de Medicamentos">
  <title>FARM SJB | @yield('title', 'Sistema de Venta de Medicamentos')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
          <p class="text-secondary mb-0">@yield('description')</p>

          <nav aria-label="Ruta de navegación">
            <ol class="breadcrumb mb-0 small">
              <li class="breadcrumb-item"><span>@yield('item_section')</span></li>
              <li class="breadcrumb-item text-muted fw-medium" aria-current="page">
                <a href="@yield('route_section')" class="text-decoration-none text-muted">
                  @yield('section')
                </a>
              </li>
              <li class="breadcrumb-item">
                <span class="text-secondary">@yield('module')</span>
              </li>
            </ol>
          </nav>
        </div>

        @include('partials.alerts')

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
