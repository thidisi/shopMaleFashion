<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductionController;
use Illuminate\Support\Facades\Route;

Route::post('reviews', [CommentController::class, 'review_products'])->name('reviewProducts');
Route::post('comments', [CommentController::class, 'add_comments'])->name('addComments');

Route::get('filterProductsList', [ProductionController::class, 'filter_list'])->name('products.filter');
Route::post('search', [ProductionController::class, 'search'])->name('products.search');
Route::get('{production:slug}' . '.html', [ProductionController::class, 'view'])->name('productDetail');
