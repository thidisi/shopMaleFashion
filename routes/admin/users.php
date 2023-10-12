<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('users', 'index')->middleware('check.role:' . 'manager')->name('users');
        Route::get('users/api', 'api')->name('users.api');
        Route::get('users/edit/{user}', 'edit')
            ->middleware('check.role:' . 'manager')
            ->name('users.edit');
        Route::put('users/edit/{user}', 'update')->middleware('check.role:' . 'manager')->name('users.update');
        Route::delete('users/{userId}', 'destroy')->middleware('check.role:' . 'manager')->name('users.destroy');
    });
