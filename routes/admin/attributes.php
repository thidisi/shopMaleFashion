<?php

use App\Http\Controllers\Admin\AttributeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:sanctum')
    ->controller(AttributeController::class)
    ->group(function () {
        Route::get('attributes', 'index')->name('attributes');
        Route::get('attributes/create', 'create')->name('attributes.create');
        Route::post('attributes/create', 'store')->name('attributes.store');
        Route::get('attributes/edit/{attribute}', 'edit')->name('attributes.edit');
        Route::put('attributes/edit/{attribute}', 'update')->name('attributes.update');
        Route::get('attribute-values/create', 'createValue')->name('attributeValues.create');
        Route::post('attribute-values/create', 'storeVaLue')->name('attributeValues.store');
        Route::get('attribute-values/edit/{attributeValue}', 'editValue')->name('attributeValues.edit');
        Route::put('attribute-values/edit/{attributeValue}', 'updateValue')->name('attributeValues.update');
        // Route::delete('attributes/{attributeId}', 'destroy')->name('attributes.destroy');
        Route::delete('attribute-values/{attributeValueId}', 'destroyVaLue')->name('attributeValues.destroy');
    });
