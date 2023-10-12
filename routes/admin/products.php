<?php

use App\Http\Controllers\Admin\ProductionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(ProductionController::class)
    ->group(function () {
        Route::get('productions', 'index')->name('productions');
        Route::get('productions/create', 'create')->name('productions.create');
        Route::post('productions/create', 'store')->name('productions.store');
        Route::get('productions/edit/{production}', 'edit')->name('productions.edit');
        Route::put('productions/edit/{production}', 'update')->name('productions.update');
        Route::delete('productions/{productionId}', 'destroy')->name('productions.destroy');
    });
