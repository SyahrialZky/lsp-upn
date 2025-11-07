@extends('layouts.app')
@section('title','Checkout')

@section('content')
<h1 class="h4 mb-3">Checkout</h1>

@php
  $cart = session('cart', []);
  $total = collect($cart)->sum(fn($i)=> $i['price'] * $i['qty']);
@endphp

@if(empty($cart))
  <div class="alert alert-info">Keranjang kosong.</div>
  <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali Belanja</a>
@else
<div class="row g-4">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">Data Pengiriman & Pembayaran</div>
      <div class="card-body">
        <form action="{{ route('checkout.submit') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat Pengiriman</label>
            <textarea name="shipping_address" rows="4" class="form-control" required>{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="payment_method" class="form-select" required>
              <option value="transfer" selected>Transfer Bank (Manual)</option>
              <option value="manual">Bayar di Tempat (simulasi)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan (opsional)</label>
            <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
          </div>
          <button class="btn btn-primary">Buat Pesanan</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card">
      <div class="card-header">Ringkasan Pesanan</div>
      <div class="card-body">
        <ul class="list-group mb-3">
          @foreach($cart as $it)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">{{ $it['name'] }}</div>
                <div class="small text-muted">Qty: {{ $it['qty'] }}</div>
              </div>
              <div>Rp {{ number_format($it['price']*$it['qty'],0,',','.') }}</div>
            </li>
          @endforeach
        </ul>
        <div class="d-flex justify-content-between">
          <div class="fw-bold">Total</div>
          <div class="fw-bold">Rp {{ number_format($total,0,',','.') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
