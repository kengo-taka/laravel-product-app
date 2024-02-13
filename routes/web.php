<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;

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

// Route::get("/",[ProductController::class, "index"])->name("top");

Route::group(['middleware' => ['auth']], function () {
  Route::get('/', [ProductController::class, 'index'])->name('top');
  Route::get('/create', [ProductController::class, 'create'])->name('product.create');
  Route::post('/store', [ProductController::class, 'store'])->name('product.store');
  Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
  Route::patch('/{product}/update', [ProductController::class, 'update'])->name('product.update');
  Route::delete('/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
});