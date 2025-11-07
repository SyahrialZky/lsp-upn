@extends('admin.layouts.app')
@section('title','Edit Kategori')
@section('page-title','Edit Kategori')

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.categories.update') }}" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Slug (opsional)</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Deskripsi (opsional)</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
      </div>
      <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
