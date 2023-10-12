<?php

use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(BlogController::class)
    ->group(function () {
        Route::get('blogs', 'index')->name('blogs');
        Route::get('blogs/create', 'create')->name('blogs.create');
        Route::post('blogs/create', 'store')->name('blogs.store');
        Route::get('blogs/edit/{blog}', 'edit')->name('blogs.edit');
        Route::put('blogs/edit/{blog}', 'update')->name('blogs.update');
        Route::delete('blogs/{blogId}', 'destroy')->name('blogs.destroy');
    });
