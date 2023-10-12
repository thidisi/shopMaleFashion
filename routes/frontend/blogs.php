<?php

use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('blogs' . '.html', [BlogController::class, 'view'])->name('blogs');
Route::get('blogs/{blog:slug}' . '.html', [BlogController::class, 'detail'])->name('blogs.detail');
