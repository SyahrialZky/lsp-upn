<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'phone',
        'shipping_address',
        'notes',
        'proof_path',
    ];

    protected $casts = [
        'total_price'    => 'integer',
        'status'         => OrderStatus::class,   // comment out jika belum pakai enum
        'payment_status' => PaymentStatus::class, // comment out jika belum pakai enum
    ];

    // Relasi
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeMine($q, ?int $userId)
    {
        if (!$userId) return $q->whereNull('user_id');
        return $q->where('user_id', $userId);
    }
    public function scopeStatus($q, ?string $status)
    {
        if (blank($status)) return $q;
        return $q->where('status', $status);
    }
    public function scopePayment($q, ?string $paymentStatus)
    {
        if (blank($paymentStatus)) return $q;
        return $q->where('payment_status', $paymentStatus);
    }

    // Helper ringkas
    public function markPaid(): void
    {
        $this->update([
            'status' => OrderStatus::Paid->value,
            'payment_status' => PaymentStatus::Paid->value,
        ]);
    }

    // Event: auto-generate code jika kosong
    protected static function booted(): void
    {
        static::creating(function (Order $o) {
            if (blank($o->code)) {
                $o->code = 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
            }
        });
    }
}
