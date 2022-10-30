<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AttributeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\DiscountProductController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes for admin
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// group name
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login', [AuthController::class, 'index'])->name('login');
        Route::post('handle', [AuthController::class, 'handleLogin'])->name('handle.login');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('register', [AuthController::class, 'register'])->name('register');
        Route::post('register', [AuthController::class, 'registering'])->name('registering');
        // Route::get('/auth/redirect/{provider}', function ($provider) {
        //     return Socialite::driver($provider)->redirect();
        // })->name('auth.redirect');
        // Route::get('/auth/callback/{provider}', [AuthController::class, 'callback'])->name('auth.callback');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware('check.login.admin.page')
    ->group(function () {
        Route::get('dashboards', [DashboardController::class, 'index'])->name('dashboards');
        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::get('users/api', [UserController::class, 'api'])->name('users.api');
        Route::get('users/edit/{user}', [UserController::class, 'edit'])
            ->middleware('check.role.admin')
            ->name('users.edit');
        Route::put('users/edit/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{userId}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('customers', [CustomerController::class, 'index'])->name('customers');
        Route::get('customers/api', [CustomerController::class, 'api'])->name('customers.api');
        Route::put('customers/{userId}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('customers/{userId}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        Route::get('major-categories', [MenuController::class, 'index'])->name('major-categories');
        Route::get('major-categories/create', [MenuController::class, 'create'])->name('major-categories.create');
        Route::post('major-categories/create', [MenuController::class, 'store'])->name('major-categories.store');
        Route::get('major-categories/edit/{majorCategory}', [MenuController::class, 'edit'])->name('major-categories.edit');
        Route::put('major-categories/edit/{majorCategory}', [MenuController::class, 'update'])->name('major-categories.update');

        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/edit/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{categoryId}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
        Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('blogs/create', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('blogs/edit/{blog}', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('blogs/edit/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('blogs/{blogId}', [BlogController::class, 'destroy'])->name('blogs.destroy');

        Route::get('slides', [SlideController::class, 'index'])->name('slides');
        Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
        Route::post('slides/create', [SlideController::class, 'store'])->name('slides.store');
        Route::get('slides/edit/{slide}', [SlideController::class, 'edit'])->name('slides.edit');
        Route::put('slides/edit/{slide}', [SlideController::class, 'update'])->name('slides.update');
        Route::delete('slides/{slideId}', [SlideController::class, 'destroy'])->name('slides.destroy');

        Route::get('attributes', [AttributeController::class, 'index'])->name('attributes');
        Route::get('attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
        Route::post('attributes/create', [AttributeController::class, 'store'])->name('attributes.store');
        Route::get('attributes/edit/{attribute}', [AttributeController::class, 'edit'])->name('attributes.edit');
        Route::put('attributes/edit/{attribute}', [AttributeController::class, 'update'])->name('attributes.update');
        Route::get('attribute-values/create', [AttributeController::class, 'createValue'])->name('attributeValues.create');
        Route::post('attribute-values/create', [AttributeController::class, 'storeVaLue'])->name('attributeValues.store');
        Route::get('attribute-values/edit/{attributeValue}', [AttributeController::class, 'editValue'])->name('attributeValues.edit');
        Route::put('attribute-values/edit/{attributeValue}', [AttributeController::class, 'updateValue'])->name('attributeValues.update');
        // Route::delete('attributes/{attributeId}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
        Route::delete('attribute-values/{attributeValueId}', [AttributeController::class, 'destroyVaLue'])->name('attributeValues.destroy');

        Route::get('productions', [ProductionController::class, 'index'])->name('productions');
        Route::get('productions/create', [ProductionController::class, 'create'])->name('productions.create');
        Route::post('productions/create', [ProductionController::class, 'store'])->name('productions.store');
        // Route::post('productions/create', [ProductionController::class, 'checkSize'])->name('productions.checkSize');
        Route::get('productions/edit/{production}', [ProductionController::class, 'edit'])->name('productions.edit');
        Route::put('productions/edit/{production}', [ProductionController::class, 'update'])->name('productions.update');
        Route::delete('productions/{productionId}', [ProductionController::class, 'destroy'])->name('productions.destroy');

        Route::get('discounts', [DiscountController::class, 'index'])->name('discounts');
        Route::get('discounts/create', [DiscountController::class, 'create'])->name('discounts.create');
        Route::post('discounts/create', [DiscountController::class, 'store'])->name('discounts.store');
        Route::get('discounts/edit/{discount}', [DiscountController::class, 'edit'])->name('discounts.edit');
        Route::put('discounts/edit/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
        Route::delete('discounts/{discountId}', [DiscountController::class, 'destroy'])->name('discounts.destroy');

        Route::get('discount-products', [DiscountProductController::class, 'index'])->name('discountProducts');
        Route::get('discount-products/create', [DiscountProductController::class, 'create'])->name('discountProducts.create');
        Route::post('discount-products/create', [DiscountProductController::class, 'store'])->name('discountProducts.store');
        Route::get('discount-products/edit/{discountProduct}', [DiscountProductController::class, 'edit'])->name('discountProducts.edit');
        Route::put('discount-products/edit/{discountProduct}', [DiscountProductController::class, 'update'])->name('discountProducts.update');
        Route::delete('discount-products/{discountProductId}', [DiscountProductController::class, 'destroy'])->name('discountProducts.destroy');

        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders/show/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/action/{action?}', [OrderController::class, 'action'])->name('orders.action');

        Route::get('abouts', [AboutController::class, 'index'])->name('abouts');
        Route::get('abouts/edit/{about}', [AboutController::class, 'edit'])->name('abouts.edit');
        Route::put('abouts/edit/{about}', [AboutController::class, 'update'])->name('abouts.update');

        Route::get('contacts', [ContactController::class, 'index'])->name('contacts');
        Route::get('contacts/seen-mail/{contact}', [ContactController::class, 'seenMail'])->name('contacts.seenMail');
        Route::post('contacts/seen-mail/{contact}', [ContactController::class, 'putSeenMail'])->name('contacts.putSeenMail');

        Route::get('comments', [CommentController::class, 'index'])->name('comments');
        Route::post('comments/feedback', [CommentController::class, 'feedback'])->name('comments.feedback');
        Route::post('comments/{comment}', [CommentController::class, 'action'])->name('comments.action');
    });
