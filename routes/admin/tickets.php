<?php

use App\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(TicketController::class)
    ->group(function () {
        Route::get('tickets', 'index')->middleware('check.role:' . 'manager')->name('tickets.index');
        Route::delete('tickets/{ticketId}', 'destroy')->middleware('check.role:' . 'manager')->name('tickets.destroy');
        Route::post('tickets/store', 'store')->middleware('check.role:' . 'manager')->name('tickets.store');
    });
