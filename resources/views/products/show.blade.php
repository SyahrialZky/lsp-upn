@extends('layouts.app')
@section('title',$product->name)

@section('content')
<div class="row g-4">
  <div class="col-md-6">
    <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://picsum.photos/800/600?random='.$product->id }}"
         class="img-fluid rounded" alt="{{ $product->name }}">
  </div>
  <div class="col-md-6">
    <h1 class="h4">{{ $product->name }}</h1>
    <div class="text-muted mb-2">Kategori: {{ $product->category?->name ?? '-' }}</div>
    <div class="mb-3">
      <span class="badge bg-{{ ($product->condition->value ?? $product->condition) === 'classic' ? 'secondary' : 'info' }}">
        {{ ucfirst($product->condition->value ?? $product->condition) }}
      </span>
      <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
        {{ $product->stock > 0 ? 'Stok tersedia' : 'Stok habis' }}
      </span>
    </div>
    <h3 class="fw-bold">Rp {{ number_format($product->price,0,',','.') }}</h3>
    <p class="mt-3">{{ $product->description }}</p>

    <form action="{{ route('cart.add') }}" method="post" class="mt-4">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <div class="input-group" style="max-width: 220px;">
        <input type="number" name="qty" value="1" min="1" class="form-control">
        <button class="btn btn-primary" {{ $product->stock < 1 ? 'disabled' : '' }}>Tambah ke Keranjang</button>
      </div>
    </form>
  </div>
</div>
@endsection
