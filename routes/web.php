<?php

use App\Http\Controllers\Auth\SocialLoginController;

use App\Http\Controllers\Desktop\OrdersController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\VinylController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Desktop\DesktopController;
use App\Http\Controllers\Desktop\ProductsController;

Route::redirect('/shop', '/shop/vinyl');

// Public Area
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('faq', [HomeController::class, 'faq'])->name('home.faq');
Route::get('terms-and-conditions', [HomeController::class, 'termsAndConditions'])->name('home.terms');
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('home.policy');
Route::get('cookie-policy', [HomeController::class, 'cookiePolicy'])->name('home.cookie');
Route::get('delivery-policy', [HomeController::class, 'deliveryPolicy'])->name('home.delivery');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('home.contact-us');
Route::post('contact-us', [HomeController::class, 'submitContactUs'])->name('home.contact-us.submit');
Route::get('search', [SearchController::class, 'search'])->name('shop.search');

Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}/redirect', [SocialLoginController::class, 'socialLoginRedirect'])->name('auth.social.redirect');
    Route::get('{provider}/callback', [SocialLoginController::class, 'socialLoginCallback'])->name('auth.social.callback');
    Route::get('{provider}/delete', [SocialLoginController::class, 'socialLoginDelete'])->name('auth.social.delete');
});

Route::group(['prefix' => 'shop'], function () {

    Route::group(['prefix' => 'checkout', 'middleware' => ['auth']], function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('shop.checkout.index');
        Route::post('/submit', [CheckoutController::class, 'submitOrder'])->name('shop.checkout.submit');
        Route::post('/order/secret', [CheckoutController::class, 'getClientStripeSecret'])->name('shop.checkout.payment.secret');
        Route::get('/order/{orderID}', [CheckoutController::class, 'orderDetails'])->name('shop.checkout.order.details');
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

Route::group(['prefix' => 'account', 'middleware' => ['permissions.role:user|super_admin']], function () {

    Route::get('/details', [AccountController::class, 'index'])->name('user.account.home');
    Route::get('/orders', [AccountController::class, 'orders'])->name('user.account.orders');
});

// Admin Area
Route::group(['prefix' => 'desktop', 'middleware' => ['permissions.role:super_admin']], function () {

    Route::get('/', [DesktopController::class, 'home'])->name('desktop.home');

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductsController::class, 'home'])->name('desktop.products.home');
        Route::get('/create', [ProductsController::class, 'create'])->name('desktop.products.create');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrdersController::class, 'home'])->name('desktop.orders.home');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
