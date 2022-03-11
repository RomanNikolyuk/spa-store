<?php

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

require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
require __DIR__ . '/admin.php';

Route::view('/', 'index');
Route::view('catalog/{alias?}/{alias2?}', 'index');
Route::view('item/{id}', 'index')->name('item');
Route::view('wishlist', 'index');
Route::view('cart', 'index');
