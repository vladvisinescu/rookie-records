<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\VinylController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Desktop\DesktopController;
use App\Http\Controllers\Desktop\ProductsController;

Route::redirect('/shop', '/shop/vinyl');

// Public Area
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'shop'], function () {

    Route::group(['prefix' => 'checkout', 'middleware' => ['auth']], function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('shop.checkout.index');
        Route::post('/submit', [CheckoutController::class, 'submitOrder'])->name('shop.checkout.submit');
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', [CartController::class, 'getCartSession'])->name('shop.cart.get');
        Route::post('/', [CartController::class, 'addToCart'])->name('shop.cart.add');
        Route::delete('/{id}', [CartController::class, 'removeFromCart'])->name('shop.cart.add');
    });

    Route::group(['prefix' => 'vinyl'], function () {

        Route::group(['prefix' => 'api'], function () {
            Route::get('/', [VinylController::class, 'getVinyls'])->name('shop.vinyl');
            Route::get('/filter-data', [VinylController::class, 'getFilterData'])->name('shop.vinyl.filter-data');
        });

        Route::get('/', [VinylController::class, 'index'])->name('shop.index');
        Route::get('/{slug}', [VinylController::class, 'show'])->name('shop.vinyl.show');
    });
});

// Admin Area
Route::group(['prefix' => 'desktop', 'middleware' => ['permissions.role:super_admin']], function () {

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
