<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('orders' . '.html', [OrderController::class, 'order_detail'])->name('order_detail');
Route::get('checkout' . '.html', [CartController::class, 'checkout'])->name('checkout');
Route::post('checkout', [OrderController::class, 'check_out'])->name('cart.checkout');
