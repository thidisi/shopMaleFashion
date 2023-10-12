<?php

use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('contact' . '.html', [ContactController::class, 'view'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
