<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlidersController;

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

Route::prefix('api')->group(function () {
    Route::get('sliders', [SlidersController::class, 'api']);

    Route::get('main-page-products', [ProductsController::class, 'mainPage']);
    Route::get('products', [ProductsController::class, 'catalog']);
    Route::get('product', [ProductsController::class, 'viewOne']);

    Route::get('main-page-categories', [CategoriesController::class, 'api']);
    Route::get('get-children-categories', [CategoriesController::class, 'getChildren']);

    Route::get('order', [OrderController::class, 'api']);
});
