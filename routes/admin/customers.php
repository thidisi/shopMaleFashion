<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->controller(CustomerController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('customers', 'index')->middleware('check.role:' . 'manager')->name('customers');
        Route::get('customers/api', 'api')->middleware('check.role:' . 'manager')->name('customers.api');
        Route::put('customers/{userId}', 'update')->middleware('check.role:' . 'manager')->name('customers.update');
        Route::delete('customers/{userId}', 'destroy')->middleware('check.role:' . 'manager')->name('customers.destroy');
    });
