<?php

use App\Http\Controllers\Admin\SlideController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(SlideController::class)
    ->group(function () {
        Route::get('slides', 'index')->middleware('check.role:' . 'manager')->name('slides');
        Route::get('slides/create', 'create')->middleware('check.role:' . 'manager')->name('slides.create');
        Route::post('slides/create', 'store')->middleware('check.role:' . 'manager')->name('slides.store');
        Route::get('slides/edit/{slide}', 'edit')->middleware('check.role:' . 'manager')->name('slides.edit');
        Route::put('slides/edit/{slide}', 'update')->middleware('check.role:' . 'manager')->name('slides.update');
        Route::delete('slides/{slideId}', 'destroy')->middleware('check.role:' . 'manager')->name('slides.destroy');
    });
