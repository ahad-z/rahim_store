<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
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

Route::get('/', [PageController::class, 'index']);
Route::get('all-products', [PageController::class, 'getALlProduct'])->name('allProduct');

Route::get('products', [ProductController::class, 'index']);
Route::get('products-all', [ProductController::class, 'getAllProduct'])->name('getAllProduct');
Route::post('store', [ProductController::class, 'store'])->name('store');
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('update', [ProductController::class, 'update'])->name('update');
Route::DELETE('delete/{id}', [ProductController::class, 'destroy'])->name('delete');
