<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::post('signUp', [HomeController::class, 'signUp'])->name('signUp');
Route::post('handleLogin', [HomeController::class, 'handleLogin'])->name('handleLogin');
Route::post('forgot_password', [HomeController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('change_password', [HomeController::class, 'changePassword'])->name('changePassword');
Route::post('logout', [HomeController::class, 'logout'])->name('logout');
