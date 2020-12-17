<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\MainPageProductsController;

use App\Http\Controllers\MainPageCategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductController;
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


Route::prefix('api')->group(function () {

    Route::get('sliders', [SlidersController::class, 'api']);

    Route::get('main-page-products', [MainPageProductsController::class, 'api']);

    Route::get('main-page-categories', [MainPageCategoriesController::class, 'api']);

    Route::get('products', [ProductsController::class, 'api']);

    Route::get('product', [ProductController::class, 'api']);
});
