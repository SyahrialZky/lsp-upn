<?php

namespace App\Http\Controllers;

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
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        return view('checkout.form', compact('cart', 'total'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:30',
            'shipping_address' => 'required|string|max:1000',
            'payment_method' => 'required|in:transfer,manual',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        return DB::transaction(function () use ($request, $cart) {
            // Lock stok agar konsisten
            foreach ($cart as $it) {
                $p = Product::lockForUpdate()->find($it['product_id']);
                if (!$p || !$p->is_active || $p->stock < $it['qty']) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Stok berubah/kurang untuk ' . ($p->name ?? 'produk'));
                }
            }

            $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

            $order = Order::create([
                'user_id'         => auth()->id(),
                'code'            => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'total_price'     => $total,
                'status'          => 'pending',
                'payment_method'  => $request->payment_method,
                'payment_status'  => 'unpaid',
                'phone'           => $request->phone,
                'shipping_address' => $request->shipping_address,
                'notes'           => $request->notes,
            ]);

            foreach ($cart as $it) {
                $p = Product::lockForUpdate()->find($it['product_id']);
                $qty = min($it['qty'], $p->stock);

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

            session()->forget('cart');

            return redirect()->route('orders.show', $order->code)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran sesuai metode yang dipilih.');
        });
    }
}
