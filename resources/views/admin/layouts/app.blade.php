<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin') — {{ config('app.name') }}</title>

  {{-- Font & Icons --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

  {{-- Bootstrap 4.6 + AdminLTE v3 + overlayScrollbars (CDN) --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/css/OverlayScrollbars.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"/>

  <style>
    /* opsional: kecilkan tabel */
    .table td, .table th { vertical-align: middle; }
  </style>
  @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- NAVBAR --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Kunjungi Toko</a>
      </li>
    </ul>
    <!-- Right -->
    <ul class="navbar-nav ml-auto">
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-user"></i> {{ auth()->user()->name }}</a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('orders.index') }}" class="dropdown-item">Pesanan Saya</a>
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="post" class="px-3">@csrf
            <button class="btn btn-sm btn-outline-danger btn-block">Logout</button>
          </form>
        </div>
      </li>
      @endauth
    </ul>
  </nav>

  {{-- SIDEBAR --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none">
      <span class="brand-text font-weight-light">{{ config('app.name','Moto Classic') }}</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item has-treeview {{ request()->is('admin/products*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-motorcycle"></i>
              <p>Produk<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="{{ route('admin.products.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Daftar</p></a></li>
              <li class="nav-item"><a href="{{ route('admin.products.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Tambah</p></a></li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ request()->is('admin/categories*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kategori<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Daftar</p></a></li>
              <li class="nav-item"><a href="{{ route('admin.categories.create') }}" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Tambah</p></a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Pesanan</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  {{-- CONTENT --}}
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">@yield('page-title','Dashboard')</h1>
        @yield('page-actions')
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @if($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        @yield('content')
      </div>
    </section>
  </div>

  {{-- FOOTER --}}
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">AdminLTE v3</div>
    <strong>&copy; {{ date('Y') }} {{ config('app.name') }}</strong> — All rights reserved.
  </footer>
</div>

{{-- JS: jQuery → Bootstrap 4 bundle → overlayScrollbars → AdminLTE --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
