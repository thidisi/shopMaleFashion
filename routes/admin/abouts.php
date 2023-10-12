<?php

use App\Http\Controllers\Admin\AboutController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(AboutController::class)
    ->group(function () {
        Route::get('abouts', 'index')->middleware('check.role:' . 'manager')->name('abouts');
        Route::get('abouts/edit/{about}', 'edit')->middleware('check.role:' . 'manager')->name('abouts.edit');
        Route::put('abouts/edit/{about}', 'update')->middleware('check.role:' . 'manager')->name('abouts.update');
    });
