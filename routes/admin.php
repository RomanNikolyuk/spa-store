<?php

use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\Admin\SliderController as AdminSlidersController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::redirect('/', '/admin/dashboard');

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard/{id}', [DashboardController::class, 'view'])->name('dashboard.view');

    Route::match(
        ['get', 'post'],
        'dashboard/{id}/changeStatus',
        [DashboardController::class, 'changeStatus']
    )->name('dashboard.changeStatus');

    Route::get('products', [AdminProductsController::class, 'products'])->name('products');

    Route::get('products/new', [AdminProductsController::class, 'new'])->name('products.new');
    Route::post('product/new', [AdminProductsController::class, 'save_new'])->name('products.save_new');

    Route::post('product/upload', [AdminProductsController::class, 'upload'])->name('products.upload');

    Route::get('products/{id}', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [AdminProductsController::class, 'save_edit'])->name('products.save_edit');
    Route::delete('products/{id}', [AdminProductsController::class, 'delete'])->name('products.delete');

    Route::get('categories', [AdminCategoriesController::class, 'categories'])->name('categories');
    Route::get('categories/new', [AdminCategoriesController::class, 'new'])->name('categories.new');
    Route::get('categories/{category_id}', [AdminCategoriesController::class, 'edit'])->name('categories.edit');

    Route::post('categories', [AdminCategoriesController::class, 'save_new'])->name('categories.save_new');
    Route::put(
        'categories/{category_id}',
        [AdminCategoriesController::class, 'save_edit']
    )->name('categories.save_edit');
    Route::delete('categories/{category_id}', [AdminCategoriesController::class, 'delete'])->name('categories.delete');

    Route::get('slider', [AdminSlidersController::class, 'slider'])->name('slider');
    Route::get('slider/new', [AdminSlidersController::class, 'new'])->name('slider.new');
    Route::get('slider/{id}', [AdminSlidersController::class, 'edit'])->name('slider.edit');

    Route::put('slider/{id}', [AdminSlidersController::class, 'save_edit'])->name('slider.save_edit');
    Route::post('slider/new', [AdminSlidersController::class, 'save_new'])->name('slider.save_new');
    Route::delete('slider/{id}', [AdminSlidersController::class, 'delete'])->name('slider.delete');
});