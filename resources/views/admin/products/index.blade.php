@extends('admin.layouts.app')
@section('title','Produk')
@section('page-title','Produk')
@section('page-actions')
  <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
@endsection

@section('content')
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:60px">#</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kondisi</th>
            <th>Aktif</th>
            <th style="width:140px"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td class="fw-semibold">{{ $p->name }}</td>
            <td>{{ $p->category?->name ?? '-' }}</td>
            <td>Rp {{ number_format($p->price,0,',','.') }}</td>
            <td>{{ $p->stock }}</td>
            <td><span class="badge bg-{{ $p->condition === 'classic' ? 'secondary' : 'info' }}">{{ ucfirst($p->condition->value ?? $p->condition) }}</span></td>
            <td>{!! $p->is_active ? '<span class="badge bg-success">Ya</span>' : '<span class="badge bg-danger">Tidak</span>' !!}</td>
            <td class="text-end">
              <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
              <form action="{{ route('admin.products.destroy',$p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer">
    {{ $products->links() }}
  </div>
</div>
@endsection
