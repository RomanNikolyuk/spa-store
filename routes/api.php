<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\SlidersController;
use Illuminate\Support\Facades\Route;

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
