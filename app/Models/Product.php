<?php

namespace App\Models;

use App\Enums\ProductCondition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'condition',
        'thumbnail',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'integer',
        'stock'     => 'integer',
        'is_active' => 'boolean',
        'condition' => ProductCondition::class, // comment out jika belum pakai enum
    ];

    // Relasi
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes berguna untuk listing & filter
    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
    public function scopeSearch($q, ?string $term)
    {
        if (blank($term)) return $q;
        return $q->where(function ($qq) use ($term) {
            $qq->where('name', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }
    public function scopeCondition($q, ?string $cond)
    {
        if (blank($cond)) return $q;
        return $q->where('condition', $cond);
    }
    public function scopeInCategory($q, ?int $categoryId)
    {
        if (blank($categoryId)) return $q;
        return $q->where('category_id', $categoryId);
    }

    // Accessor: format rupiah cepat
    public function getPriceRpAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Event: slug otomatis jika kosong
    protected static function booted(): void
    {
        static::creating(function (Product $p) {
            if (blank($p->slug) && filled($p->name)) {
                $p->slug = Str::slug($p->name . '-' . Str::random(4));
            }
        });
         static::saving(function (Product $product) {
            if ($product->stock < 0) {
                $product->stock = 0;
            }

            if ($product->stock === 0) {
                $product->is_active = false;
            }
            else{
                 $product->is_active = true;
            }
        });
    }
    
}
