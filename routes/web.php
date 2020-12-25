<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SlidersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
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

    Route::get('products/{id}', [AdminProductsController::class, 'view'])->name('products.view');

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
