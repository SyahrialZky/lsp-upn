@extends('layouts.app')
@section('title','Pesanan Saya')

@section('content')
<h1 class="h4 mb-3">Pesanan Saya</h1>

@if($orders->isEmpty())
  <div class="alert alert-info">Belum ada pesanan.</div>
@else
  <div class="list-group">
    @foreach($orders as $o)
      <a href="{{ route('orders.show',$o->code) }}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <div class="fw-semibold">{{ $o->code }}</div>
          <div class="small text-muted">{{ $o->created_at->format('d M Y H:i') }}</div>
        </div>
        <div class="text-end">
          <div class="badge bg-secondary text-uppercase">{{ $o->status }}</div>
          <div class="small">Rp {{ number_format($o->total_price,0,',','.') }}</div>
        </div>
      </a>
    @endforeach
  </div>
  <div class="mt-3">{{ $orders->links() }}</div>
@endif
@endsection
