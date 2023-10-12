<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(OrderController::class)
    ->group(function () {
        Route::get('orders', 'index')->name('orders');
        Route::get('orders/show/{order}', 'show')->name('orders.show');
        Route::post('orders/action/{action?}', 'action')->name('orders.action');
    });
