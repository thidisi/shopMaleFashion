<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('shop/{menu:slug}' . '.html', [MenuController::class, 'view'])->name('menu');

