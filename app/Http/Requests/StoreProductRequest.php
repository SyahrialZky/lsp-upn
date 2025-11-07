<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // pastikan hanya admin yang boleh akses
        return Auth::check() && Auth::user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'integer', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'condition'   => ['required', 'in:classic,custom'],
            'is_active'   => ['required', 'boolean'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'name.required'        => 'Nama produk tidak boleh kosong.',
            'price.required'       => 'Harga wajib diisi.',
            'thumbnail.image'      => 'File thumbnail harus berupa gambar.',
        ];
    }
}
