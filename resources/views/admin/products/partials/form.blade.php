<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Slug (opsional)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug ?? '') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Kategori</label>
    <select name="category_id" class="form-select" required>
      <option value="">— Pilih —</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? '') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Harga (Rp)</label>
    <input type="number" name="price" min="0" class="form-control" value="{{ old('price', $product->price ?? 0) }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Stok</label>
    <input type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Kondisi</label>
    <select name="condition" class="form-select" required>
      @foreach(['classic' => 'Classic', 'custom' => 'Custom'] as $val => $label)
        <option value="{{ $val }}" @selected(old('condition', $product->condition ?? '') == $val)>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Aktif</label>
    <select name="is_active" class="form-select" required>
      <option value="1" @selected(old('is_active', (int)($product->is_active ?? 1)) === 1)>Ya</option>
      <option value="0" @selected(old('is_active', (int)($product->is_active ?? 1)) === 0)>Tidak</option>
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Thumbnail (jpg/png/webp)</label>
    <input type="file" name="thumbnail" class="form-control">
    @isset($product->thumbnail)
      <div class="small text-muted mt-1">Saat ini: {{ $product->thumbnail }}</div>
    @endisset
  </div>
  <div class="col-12">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
  </div>
</div>
