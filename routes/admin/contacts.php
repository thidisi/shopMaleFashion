<?php

use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(ContactController::class)
    ->group(function () {
        Route::get('contacts', 'index')->name('contacts');
        Route::get('contacts/seen-mail/{contact}', 'seenMail')->name('contacts.seenMail');
        Route::post('contacts/seen-mail/{contact}', 'putSeenMail')->name('contacts.putSeenMail');
    });
