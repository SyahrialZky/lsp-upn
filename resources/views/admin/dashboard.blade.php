@extends('admin.layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $stats['orders_today'] ?? 0 }}</h3>
        <p>Pesanan Hari Ini</p>
      </div>
      <div class="icon"><i class="fas fa-calendar-day"></i></div>
      <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $stats['orders_pending'] ?? 0 }}</h3>
        <p>Menunggu Proses</p>
      </div>
      <div class="icon"><i class="fas fa-hourglass-half"></i></div>
      <a href="{{ route('admin.orders.index',['status'=>'pending']) }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $stats['products_active'] ?? 0 }}</h3>
        <p>Produk Aktif</p>
      </div>
      <div class="icon"><i class="fas fa-box"></i></div>
      <a href="{{ route('admin.products.index') }}" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ $stats['users'] ?? 0 }}</h3>
        <p>Pengguna</p>
      </div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <a href="#" class="small-box-footer disabled">—</a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header"><h3 class="card-title">Pesanan Terbaru</h3></div>
  <div class="card-body p-0">
    <table class="table table-striped mb-0">
      <thead><tr><th>Kode</th><th>User</th><th>Status</th><th>Total</th><th>Tanggal</th><th></th></tr></thead>
      <tbody>
        @forelse($latestOrders ?? [] as $o)
          <tr>
            <td>{{ $o->code }}</td>
            <td>{{ $o->user?->name ?? '-' }}</td>
            <td><span class="badge badge-secondary text-uppercase">{{ $o->status }}</span></td>
            <td>Rp {{ number_format($o->total_price,0,',','.') }}</td>
            <td>{{ $o->created_at->format('d M Y H:i') }}</td>
            <td class="text-right">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.orders.show',$o) }}">Detail</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">Belum ada pesanan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
