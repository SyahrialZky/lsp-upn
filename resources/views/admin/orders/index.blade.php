@extends('admin.layouts.app')
@section('title','Pesanan')
@section('page-title','Pesanan')

@section('content')
<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2" method="get">
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">— Semua —</option>
          @foreach(['pending','paid','processing','shipped','completed','cancelled'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Payment</label>
        <select name="payment_status" class="form-select">
          <option value="">— Semua —</option>
          @foreach(['unpaid','waiting','paid','failed'] as $s)
            <option value="{{ $s }}" @selected(request('payment_status')===$s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 align-self-end">
        <button class="btn btn-outline-primary">Filter</button>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead class="table-light"><tr>
          <th>Kode</th><th>User</th><th>Status</th><th>Pembayaran</th><th>Total</th><th>Tanggal</th><th></th>
        </tr></thead>
        <tbody>
          @foreach($orders as $o)
            <tr>
              <td>{{ $o->code }}</td>
              <td>{{ $o->user?->name ?? '-' }}</td>
              <td><span class="badge bg-secondary text-uppercase">{{ $o->status }}</span></td>
              <td>{{ strtoupper($o->payment_status->value ?? $o->payment_status) }}</td>
              <td>Rp {{ number_format($o->total_price,0,',','.') }}</td>
              <td>{{ $o->created_at->format('d M Y H:i') }}</td>
              <td class="text-end">
                <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-outline-primary">Detail</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
