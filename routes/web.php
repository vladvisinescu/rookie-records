<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VinylController;
use App\Http\Controllers\Desktop\DesktopController;
use App\Http\Controllers\Desktop\ProductsController;

Route::redirect('/shop', '/shop/vinyl');

// Public Area
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'shop'], function () {

    Route::group(['prefix' => 'vinyl'], function () {
        Route::get('/', [VinylController::class, 'index'])->name('shop.index');
    });
});

// Admin Area
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
