<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Desktop\ArtistsController;
use App\Http\Controllers\Desktop\CategoriesController;
use App\Http\Controllers\Desktop\GenresController;
use App\Http\Controllers\Desktop\DiscogsController;
use App\Http\Controllers\Desktop\OrdersController;
use App\Http\Controllers\Desktop\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->post('/search', [DiscogsController::class, 'search']);
Route::middleware('auth:sanctum')->get('/search/release/{releaseID}', [DiscogsController::class, 'getRecord']);

Route::group(['prefix' => 'products', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [ProductsController::class, 'getAllProducts']);
    Route::post('/', [ProductsController::class, 'saveProduct']);
    Route::delete('/{product}', [ProductsController::class, 'deleteProduct']);
});

Route::group(['prefix' => 'orders', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [OrdersController::class, 'getAllOrders'])->name('api.orders.all');
    Route::patch('/{order}/confirm', [OrdersController::class, 'confirmOrder'])->name('api.orders.confirm');
    Route::delete('/{order}', [OrdersController::class, 'deleteProduct'])->name('api.orders.delete');
});

Route::group(['prefix' => 'artists', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [ArtistsController::class, 'getAllArtists']);
    Route::post('/', [ArtistsController::class, 'createArtist']);
});

Route::group(['prefix' => 'genres', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [GenresController::class, 'getAllGenres']);
    Route::post('/', [GenresController::class, 'createGenre']);
});

Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [CategoriesController::class, 'getAllCategories'])->name('api.categories');
});

Route::group(['prefix' => 'addresses', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/postcode/{postcode}', [AddressController::class, 'postcodeLookup'])->name('api.addresses.lookup');
    Route::get('/', [AddressController::class, 'getAllAddresses']);
    Route::post('/', [AddressController::class, 'saveAddress']);
    Route::patch('/{address}', [AddressController::class, 'updateAddress'])->name('api.addresses.update');
    Route::delete('/{address}', [AddressController::class, 'deleteAddress'])->name('api.addresses.delete');
});

Route::group(['prefix' => 'checkout', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [AddressController::class, 'getAllAddresses']);
    Route::post('/', [AddressController::class, 'saveAddress']);
    Route::delete('/{address}', [AddressController::class, 'deleteAddress']);
});

Route::group(['prefix' => 'user'], function () {

    Route::get('/', [UserController::class, 'getUser'])->name('api.user.get');
    Route::patch('/', [UserController::class, 'updateUser'])->name('api.user.update');
    Route::get('/orders', [UserController::class, 'getOrders'])->name('api.user.orders');
});
