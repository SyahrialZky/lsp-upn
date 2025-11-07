@extends('admin.layouts.app')
@section('title','Edit Produk')
@section('page-title','Edit Produk')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.products.update',$product) }}" method="post" enctype="multipart/form-data">
      @csrf @method('PUT')
      @include('admin.products.partials.form', ['product' => $product])
      <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </form>
  </div>
</div>
@endsection
