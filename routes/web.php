<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

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

    Route::get('main-page-products', [ProductsController::class, 'mainPage']);

    Route::get('main-page-categories', [CategoriesController::class, 'api']);

    Route::get('products', [ProductsController::class, 'catalog']);

    Route::get('product', [ProductsController::class, 'viewOne']);

    Route::get('get-children-categories', [CategoriesController::class, 'getChildren']);
});
