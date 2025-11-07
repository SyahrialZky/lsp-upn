@extends('admin.layouts.app')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')

@section('page-actions')
  <form action="{{ route('admin.orders.status',$order) }}" method="post" class="d-flex gap-2">
    @csrf
    <select name="status" class="form-select form-select-sm">
      @foreach(['pending','paid','processing','shipped','completed','cancelled'] as $s)
        <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
      @endforeach
    </select>
    <button class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Update</button>
  </form>
@endsection

@section('content')
<div class="row g-3">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Item Pesanan</h3></div>
      <div class="card-body p-0">
        <table class="table mb-0">
          <thead class="table-light"><tr><th>Produk</th><th class="text-center">Qty</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
          <tbody>
            @foreach($order->items as $it)
              <tr>
                <td>{{ $it->product_name }}</td>
                <td class="text-center">{{ $it->qty }}</td>
                <td class="text-end">Rp {{ number_format($it->price,0,',','.') }}</td>
                <td class="text-end">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Total</th>
              <th class="text-end">Rp {{ number_format($order->total_price,0,',','.') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Informasi</h3></div>
      <div class="card-body">
        <div class="mb-2"><span class="text-muted">Kode:</span> {{ $order->code }}</div>
        <div class="mb-2"><span class="text-muted">Pengguna:</span> {{ $order->user?->name ?? '-' }}</div>
        <div class="mb-2"><span class="text-muted">Status:</span> <span class="badge bg-secondary text-uppercase">{{ $order->status }}</span></div>
        <div class="mb-2"><span class="text-muted">Pembayaran:</span> {{ strtoupper($order->payment_status) }} ({{ $order->payment_method }})</div>
        <div class="mb-2"><span class="text-muted">Telepon:</span> {{ $order->phone }}</div>
        <div class="mb-2"><span class="text-muted">Alamat:</span> {{ $order->shipping_address }}</div>
        @if($order->proof_path)
          <div class="mb-2"><span class="text-muted">Bukti:</span> <a href="{{ asset('storage/'.$order->proof_path) }}" target="_blank">Lihat</a></div>
        @endif
        <div class="mb-2"><span class="text-muted">Catatan:</span> {{ $order->notes ?? '-' }}</div>
        <div class="small text-muted">Dibuat: {{ $order->created_at->format('d M Y H:i') }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
