<?php

use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\DiscountProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(DiscountController::class)
    ->group(function () {
        Route::get('discounts', 'index')->name('discounts');
        Route::get('discounts/create', 'create')->name('discounts.create');
        Route::post('discounts/create', 'store')->name('discounts.store');
        Route::get('discounts/edit/{discount}', 'edit')->name('discounts.edit');
        Route::put('discounts/edit/{discount}', 'update')->name('discounts.update');
        Route::delete('discounts/{discountId}', 'destroy')->name('discounts.destroy');
    });


Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(DiscountProductController::class)
    ->group(function () {
        Route::get('discount-products', 'index')->name('discountProducts');
        Route::get('discount-products/create', 'create')->name('discountProducts.create');
        Route::post('discount-products/create', 'store')->name('discountProducts.store');
        Route::get('discount-products/edit/{discountProduct}', 'edit')->name('discountProducts.edit');
        Route::put('discount-products/edit/{discountProduct}', 'update')->name('discountProducts.update');
        Route::delete('discount-products/{discountProductId}', 'destroy')->name('discountProducts.destroy');
    });
