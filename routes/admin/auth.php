<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::controller(AuthController::class)
    ->prefix("auth")
    ->group(function () {
        Route::post('handle', 'handleLogin')->name('admin.handle.login');
        Route::post('register', 'registering')->name('admin.registering');
        Route::get('redirect/{provider}', function ($provider) {
            return Socialite::driver($provider)->redirect();
        })->name('admin.auth.redirect');
        Route::get('callback/{provider}', 'callback')->name('auth.callback');
    });
