<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $items->sum(fn($item) => $item->product->price * $item->qty);

        return view('cart.index', compact('items','total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'nullable|integer|min:1',
        ]);

        $qty = $data['qty'] ?? 1;

        $item = Cart::firstOrNew([
            'user_id'    => auth()->id(),
            'product_id' => $data['product_id'],
        ]);

        $item->qty = ($item->exists ? $item->qty : 0) + $qty;
        $item->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:0',
        ]);

        $item = Cart::where('user_id', auth()->id())
            ->where('product_id', $data['product_id'])
            ->firstOrFail();

        if ($data['qty'] == 0) {
            $item->delete();
        } else {
            $item->update(['qty' => $data['qty']]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Cart::where('user_id', auth()->id())
            ->where('product_id', $data['product_id'])
            ->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
