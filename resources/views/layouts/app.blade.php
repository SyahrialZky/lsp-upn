<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-card img { object-fit: cover; height: 180px; }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">
  {{-- NAVBAR --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('home') }}">{{ config('app.name', 'Moto Classic') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navMain" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produk</a></li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item me-2">
            <a class="btn btn-outline-light btn-sm" href="{{ route('cart.index') }}">
              Keranjang
              @php
                $count = 0;
                if(auth()->check()) {
                    $count = \App\Models\Cart::where('user_id', auth()->id())->sum('qty');
                }
              @endphp
              <span class="badge bg-light text-dark">{{ $count }}</span>
            </a>
          </li>

          @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                {{ auth()->user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                @if(auth()->user()->is_admin)
                  <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="post">@csrf
                    <button class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('login') }}">Login</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  {{-- KONTEN UTAMA --}}
  <main class="flex-grow-1">
    <div class="container py-4">
      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  {{-- FOOTER --}}
  <footer class="border-top py-4 mt-auto">
    <div class="container small text-muted">
      &copy; {{ date('Y') }} {{ config('app.name','Moto Classic') }} — Dibangun dengan Laravel + Bootstrap
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
