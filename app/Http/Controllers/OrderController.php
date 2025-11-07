<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(string $code)
    {
        $order = Order::with('items')
            ->where('code', $code)
            ->firstOrFail();

        // Pastikan user hanya bisa lihat order miliknya
        if (auth()->id() !== optional($order->user)->id) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
}
