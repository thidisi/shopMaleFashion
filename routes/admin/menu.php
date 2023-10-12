<?php

use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(MenuController::class)
    ->group(function () {
        Route::get('major-categories', 'index')->middleware('check.role:' . 'manager')->name('major-categories');
        Route::get('major-categories/create', 'create')->middleware('check.role:' . 'manager')->name('major-categories.create');
        Route::post('major-categories/create', 'store')->middleware('check.role:' . 'manager')->name('major-categories.store');
        Route::get('major-categories/edit/{majorCategory}', 'edit')->middleware('check.role:' . 'manager')->name('major-categories.edit');
        Route::put('major-categories/edit/{majorCategory}', 'update')->middleware('check.role:' . 'manager')->name('major-categories.update');
    });
