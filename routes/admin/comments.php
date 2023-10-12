<?php

use App\Http\Controllers\Admin\CommentController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(CommentController::class)
    ->group(function () {
        Route::get('comments', 'index')->name('comments');
        Route::post('comments/feedback', 'feedback')->name('comments.feedback');
        Route::post('comments/{comment}', 'action')->name('comments.action');
    });
