@extends('layouts.app')
@section('title','Keranjang')

@section('content')
<h1 class="h4 mb-3">Keranjang Belanja</h1>

@php
  $cart = session('cart', []);
  $total = collect($cart)->sum(fn($i)=> $i['price'] * $i['qty']);
@endphp

@if(empty($cart))
  <div class="alert alert-info">Keranjang kamu masih kosong.</div>
  <a href="{{ route('products.index') }}" class="btn btn-primary">Belanja Sekarang</a>
@else
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr><th>Produk</th><th class="text-end">Harga</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th><th></th></tr>
      </thead>
      <tbody>
      @foreach($cart as $item)
        <tr>
          <td>{{ $item['name'] }}</td>
          <td class="text-end">Rp {{ number_format($item['price'],0,',','.') }}</td>
          <td class="text-center">
            <form action="{{ route('cart.update') }}" method="post" class="d-inline-flex">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
              <input type="number" class="form-control form-control-sm me-2" name="qty" value="{{ $item['qty'] }}" min="1" style="width:90px;">
              <button class="btn btn-sm btn-outline-secondary">Update</button>
            </form>
          </td>
          <td class="text-end">Rp {{ number_format($item['price']*$item['qty'],0,',','.') }}</td>
          <td class="text-end">
            <form action="{{ route('cart.remove') }}" method="post" class="d-inline">
              @csrf
              <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-end">Total</th>
          <th class="text-end">Rp {{ number_format($total,0,',','.') }}</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>

  @auth
    <a href="{{ route('checkout.form') }}" class="btn btn-primary">Lanjut ke Checkout</a>
  @else
    <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Checkout</a>
  @endauth
@endif
@endsection
