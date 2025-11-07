<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with('user')->latest();
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $q->where('payment_status', $request->payment_status);
        }
        $orders = $q->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $data['status']]);

        // Opsional: jika status "paid" maka set payment_status = paid
        if ($data['status'] === 'paid' && $order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
