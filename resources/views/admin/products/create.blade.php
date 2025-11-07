@extends('admin.layouts.app')
@section('title','Tambah Produk')
@section('page-title','Tambah Produk')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      @include('admin.products.partials.form', ['product' => null])
      <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
