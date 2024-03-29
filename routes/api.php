<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('address', [CartController::class, 'getAddress'])->name('address');

Route::post('getDiscount', [OrderController::class, 'get_discount'])->name('get_discount');

Route::get('setDataTicket', [TicketController::class, 'get_data'])->middleware('auth:sanctum')->name('tickets.get_data');
Route::get('getDataTicket', [TicketController::class, 'api_data'])->middleware('auth:sanctum')->name('tickets.dataApi');
