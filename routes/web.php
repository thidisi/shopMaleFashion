<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.layout_frontend');
// });
Route::get('tests', [TestController::class, 'test']);
// Route::post('tests/ee', [TestController::class, 'check'])->name('test.check');
// Route::get('/404.html', [HomeController::class, 'errors'])->name('errors');

