@extends('layouts.app')
@section('title','Detail Pesanan')

@section('content')
<h1 class="h4 mb-3">Detail Pesanan</h1>

<div class="card mb-3">
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <div>
        <div class="fw-bold">{{ $order->code }}</div>
        <div class="small text-muted">{{ $order->created_at->format('d M Y H:i') }}</div>
      </div>
      <div class="text-end">
        <div class="badge bg-secondary text-uppercase">{{ $order->status }}</div>
        <div class="small">
          Pembayaran: {{ strtoupper($order->payment_status->value ?? $order->payment_status) }}
        </div>

      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">Item</div>
      <div class="card-body">
        <ul class="list-group">
          @foreach($order->items as $it)
            <li class="list-group-item d-flex justify-content-between">
              <div>
                <div class="fw-semibold">{{ $it->product_name }}</div>
                <div class="small text-muted">Qty: {{ $it->qty }}</div>
              </div>
              <div>Rp {{ number_format($it->subtotal,0,',','.') }}</div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="card">
      <div class="card-header">Ringkasan</div>
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <div>Total</div>
          <div class="fw-bold">Rp {{ number_format($order->total_price,0,',','.') }}</div>
        </div>
        <div class="mb-2"><span class="text-muted">Metode:</span> {{ ucfirst($order->payment_method) }}</div>
        <div class="mb-2"><span class="text-muted">Telepon:</span> {{ $order->phone }}</div>
        <div class="mb-2"><span class="text-muted">Alamat:</span> {{ $order->shipping_address }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
