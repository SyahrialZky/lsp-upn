@extends('admin.layouts.app')
@section('title','Kategori')
@section('page-title','Kategori')
@section('page-actions')
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
@endsection

@section('content')
<div class="card">
  <div class="card-body p-0">
    <table class="table mb-0 table-hover">
      <thead class="table-light"><tr><th>#</th><th>Nama</th><th>Slug</th><th></th></tr></thead>
      <tbody>
        @forelse($categories as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td class="fw-semibold">{{ $c->name }}</td>
            <td><code>{{ $c->slug }}</code></td>
            <td class="text-end">
              <a href="{{ route('admin.categories.edit',$c) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
              <form action="{{ route('admin.categories.destroy',$c) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus kategori?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Belum ada kategori.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $categories->links() }}</div>
</div>
@endsection
