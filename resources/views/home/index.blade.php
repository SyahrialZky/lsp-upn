@extends('layouts.app')
@section('title','Beranda')

@section('content')
<div class="p-4 p-md-5 mb-4 bg-light rounded-3">
  <div class="container py-5">
    <h1 class="display-5 fw-bold">Motor Classic & Custom</h1>
    <p class="col-md-8 fs-5">Temukan motor klasik, kustom, berkualitas. Langsung checkout, simple dan cepat.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Lihat Semua Produk</a>
  </div>
</div>

<h2 class="h4 mb-3">Produk Terbaru</h2>
<div class="row g-3">
  @forelse($products as $p)
    <div class="col-6 col-md-3">
      <div class="card product-card h-100">
        <img src="{{ $p->thumbnail ? asset('storage/'.$p->thumbnail) : 'https://picsum.photos/400/300?random='.$p->id }}" class="card-img-top" alt="{{ $p->name }}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title">{{ $p->name }}</h6>
          <div class="mt-auto">
            <div class="fw-bold mb-2">Rp {{ number_format($p->price,0,',','.') }}</div>
            <a href="{{ route('products.show',$p->slug) }}" class="btn btn-outline-primary btn-sm w-100">Detail</a>
          </div>
        </div>
      </div>
    </div>
  @empty
    <p>Belum ada produk.</p>
  @endforelse
</div>
@endsection
