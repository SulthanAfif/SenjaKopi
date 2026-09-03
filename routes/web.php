<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesananku', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::get('/pesananku/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::patch('/pesananku/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/pesananku/{order}/reorder', [CustomerOrderController::class, 'reorder'])->name('customer.orders.reorder');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
