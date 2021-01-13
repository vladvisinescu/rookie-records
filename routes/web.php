<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Desktop\DesktopController;
use App\Http\Controllers\Desktop\ProductsController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'index']);

Route::group(['prefix' => 'desktop'], function () {
    Route::get('/', [DesktopController::class, 'home']);

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductsController::class, 'home'])->name('desktop.products.home');
        Route::get('/create', [ProductsController::class, 'create'])->name('desktop.products.create');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
