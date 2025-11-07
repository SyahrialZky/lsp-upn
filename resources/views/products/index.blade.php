@extends('layouts.app')
@section('title','Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Semua Produk</h1>
  <form class="d-flex" method="get">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" placeholder="Cari produk...">
    <button class="btn btn-sm btn-outline-secondary">Cari</button>
  </form>
</div>

<div class="row g-3">
  @foreach($products as $p)
    <div class="col-6 col-md-3">
      <div class="card product-card h-100">
        <img src="{{ $p->thumbnail ? asset('storage/'.$p->thumbnail) : 'https://picsum.photos/400/300?random='.$p->id }}" class="card-img-top" alt="{{ $p->name }}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title">{{ $p->name }}</h6>
          <div class="text-muted small mb-2">{{ $p->category?->name }}</div>
          <div class="mt-auto">
            <div class="fw-bold mb-2">Rp {{ number_format($p->price,0,',','.') }}</div>
            <a href="{{ route('products.show',$p->slug) }}" class="btn btn-outline-primary btn-sm w-100">Detail</a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

<div class="mt-3">
  {{ $products->withQueryString()->links() }}
</div>
@endsection
