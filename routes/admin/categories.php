<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('categories', 'index')->middleware('check.role:' . 'manager')->name('categories');
        Route::get('categories/create', 'create')->middleware('check.role:' . 'manager')->name('categories.create');
        Route::post('categories/create', 'store')->middleware('check.role:' . 'manager')->name('categories.store');
        Route::get('categories/edit/{category}', 'edit')->middleware('check.role:' . 'manager')->name('categories.edit');
        Route::put('categories/edit/{category}', 'update')->middleware('check.role:' . 'manager')->name('categories.update');
        Route::delete('categories/{categoryId}', 'destroy')->middleware('check.role:' . 'manager')->name('categories.destroy');
    });
