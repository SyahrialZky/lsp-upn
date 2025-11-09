<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    public function form()
    {
        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        $total = $items->sum(fn ($item) => $item->product->price * $item->qty);

        return view('checkout.form', compact('items', 'total'));
    }

    public function submit(Request $request)
{
    $request->validate([
        'phone'            => 'required|string|max:30',
        'shipping_address' => 'required|string|max:1000',
        'payment_method'   => 'required|in:transfer,manual',
        'notes'            => 'nullable|string|max:1000',
    ]);

    // Ambil keranjang dari DB, bukan dari session lagi
    $items = Cart::with('product')
        ->where('user_id', auth()->id())
        ->get();

    if ($items->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
    }

    return DB::transaction(function () use ($request, $items) {
        // Lock stok agar konsisten
        foreach ($items as $item) {
            $p = Product::lockForUpdate()->find($item->product_id);

            if (!$p || !$p->is_active || $p->stock < $item->qty) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', 'Stok berubah/kurang untuk ' . ($p->name ?? 'produk'));
            }
        }

        // Hitung total berdasarkan harga produk saat ini
        $total = $items->sum(fn ($item) => $item->product->price * $item->qty);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'code'             => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'total_price'      => $total,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'unpaid',
            'phone'            => $request->phone,
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        foreach ($items as $item) {
            $p = Product::lockForUpdate()->find($item->product_id);

            // jaga-jaga kalau stok berubah di tengah
            $qty = min($item->qty, $p->stock);

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $p->id,
                'product_name' => $p->name,
                'price'        => $p->price,
                'qty'          => $qty,
                'subtotal'     => $p->price * $qty,
            ]);

            $p->decrement('stock', $qty);
        }

        Cart::where('user_id', auth()->id())->delete();

        session()->forget('cart');

        return redirect()
            ->route('orders.show', $order->code)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran sesuai metode yang dipilih.');
    });
}

}
