<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_today' => Order::whereDate('created_at', now()->toDateString())->count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'products_active' => Product::where('is_active', true)->count(),
            'users' => User::count(),
        ];

        $latestOrders = Order::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
