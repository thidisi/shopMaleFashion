<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('404', [HomeController::class, 'errors'])->name('errors');
Route::get('shop' . '.html', [CategoryController::class, 'view'])->name('shop');
