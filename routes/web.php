<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SlidersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\Admin\CategoriesController as AdminCategoriesController;


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


Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('dashboard/{id}', [DashboardController::class, 'view'])->name('dashboard.view');

    Route::match(['get', 'post'],'dashboard/{id}/changeStatus', [DashboardController::class, 'changeStatus'])->name('dashboard.changeStatus');

    Route::get('products', [AdminProductsController::class, 'products'])->name('products');

    Route::get('products/new', [AdminProductsController::class, 'new'])->name('products.new');
    Route::post('product/new', [AdminProductsController::class, 'save_new'])->name('products.save_new');

    Route::get('products/{id}', [AdminProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [AdminProductsController::class, 'save_edit'])->name('products.save_edit');
    Route::delete('products/{id}', [AdminProductsController::class, 'delete'])->name('products.delete');


    Route::get('categories', [AdminCategoriesController::class, 'categories'])->name('categories');
    Route::get('categories/new', [AdminCategoriesController::class, 'new'])->name('categories.new');
    Route::get('categories/{category_id}', [AdminCategoriesController::class, 'edit'])->name('categories.edit');


    Route::post('categories', [AdminCategoriesController::class, 'save_new'])->name('categories.save_new');
    Route::put('categories/{category_id}', [AdminCategoriesController::class, 'save_edit'])->name('categories.save_edit');
    Route::delete('categories/{category_id}', [AdminCategoriesController::class, 'delete'])->name('categories.delete');


});

require __DIR__.'/auth.php';

Route::prefix('api')->group(function () {

    Route::get('sliders', [SlidersController::class, 'api']);

    Route::get('main-page-products', [ProductsController::class, 'mainPage']);

    Route::get('main-page-categories', [CategoriesController::class, 'api']);

    Route::get('products', [ProductsController::class, 'catalog']);

    Route::get('product', [ProductsController::class, 'viewOne']);

    Route::get('get-children-categories', [CategoriesController::class, 'getChildren']);
});


Route::view('/', 'index');
Route::view('catalog/{alias?}', 'index');
Route::view('item/{id}', 'index');
Route::view('wishlist', 'index');
Route::view('cart', 'index');
