<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/404.html', [HomeController::class, 'errors'])->name('errors');
Route::post('/signUp', [HomeController::class, 'signUp'])->name('signUp');
Route::post('/handleLogin', [HomeController::class, 'handleLogin'])->name('handleLogin');
Route::post('/forgot_password', [HomeController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/change_password', [HomeController::class, 'changePassword'])->name('changePassword');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/shop.html', [CategoryController::class, 'view'])->name('shop');
Route::get('shop/{menu:slug}.html', [MenuController::class, 'view'])->name('menu');

Route::get('/blogs.html', [BlogController::class, 'view'])->name('blogs');
Route::get('/blogs-details-{blog}.html', [BlogController::class, 'detail'])->name('blogs.detail');


Route::get('/contact.html', [ContactController::class, 'view'])->name('contact');
Route::post('/contact.html', [ContactController::class, 'store'])->name('contact.store');

Route::get('/carts.html', [CartController::class, 'index'])->name('cart');
Route::post('/carts.html', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('/carts.html/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/carts.html/{cartId}', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('/carts.html/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
Route::get('orders.html', [OrderController::class, 'order_detail'])->name('order_detail');

Route::get('/checkout.html', [CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout.html', [OrderController::class, 'check_out'])->name('cart.checkout');


Route::post('/reviews', [CommentController::class, 'review_products'])->name('reviewProducts');
Route::post('/comments', [CommentController::class, 'add_comments'])->name('addComments');

Route::get('/{production:slug}.html', [ProductionController::class, 'view'])->name('productDetail');


