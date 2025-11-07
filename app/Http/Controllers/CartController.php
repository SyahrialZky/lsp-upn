<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($data['product_id']);
        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = session('cart', []);
        $key = (string)$product->id;
        $qty = max(1, (int)($data['qty'] ?? 1));

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty
            ];
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);
        if (isset($cart[$data['product_id']])) {
            $cart[$data['product_id']]['qty'] = $data['qty'];
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required'
        ]);

        $cart = session('cart', []);
        unset($cart[$data['product_id']]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item dihapus.');
    }
}
