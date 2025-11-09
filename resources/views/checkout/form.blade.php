@extends('layouts.app')
@section('title','Checkout')

@section('content')
<h1 class="h4 mb-3">Checkout</h1>

<div class="row">
  <div class="col-md-8">
    <div class="card mb-3">
      <div class="card-header">Data Pengiriman</div>
      <div class="card-body">
        <form action="{{ route('checkout.submit') }}" method="post">
          @csrf

          <div class="mb-3">
            <label class="form-label">Nama Penerima</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Pengiriman</label>
            <textarea name="shipping_address" rows="3" class="form-control" required>{{ old('shipping_address') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="payment_method" class="form-select">
              <option value="transfer">Transfer Bank</option>
              <option value="cod" disabled>COD (Coming soon)</option>
            </select>
          </div>

          <button class="btn btn-primary">Buat Pesanan</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">Ringkasan Belanja</div>
      <div class="card-body">
        <ul class="list-unstyled mb-3">
          @foreach($items as $item)
            <li class="mb-2 d-flex justify-content-between">
              <div>
                <div>{{ $item->product->name }}</div>
                <div class="small text-muted">Qty: {{ $item->qty }}</div>
              </div>
              <div>Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</div>
            </li>
          @endforeach
        </ul>
        <hr>
        <div class="d-flex justify-content-between fw-bold">
          <span>Total</span>
          <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
