<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    CartController,
    CheckoutController,
    OrderController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    ProductController as AdminProductController,
    CategoryController as AdminCategoryController,
    OrderController as AdminOrderController
};

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // CART
    Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart',         [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT
    Route::get('/checkout',  [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'submit'])->name('checkout.submit');

    // ORDERS
    Route::get('/orders',        [OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/orders/{code}', [OrderController::class, 'show'])->name('orders.show');
});

// === ADMIN ===
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
