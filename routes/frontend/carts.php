<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('carts' . '.html', [CartController::class, 'index'])->name('cart');
Route::post('carts', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('carts/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('carts/{cartId}', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('carts/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
