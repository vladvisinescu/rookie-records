<?php

use App\Http\Controllers\Desktop\ArtistsController;
use App\Http\Controllers\Desktop\GenresController;
use App\Http\Controllers\Desktop\DiscogsController;
use App\Http\Controllers\Desktop\ProductsController;
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

    Route::post('/', [ProductsController::class, 'saveProduct']);
});

Route::group(['prefix' => 'artists', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [ArtistsController::class, 'getAllArtists']);
    Route::post('/', [ArtistsController::class, 'createArtist']);
});

Route::group(['prefix' => 'genres', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/', [GenresController::class, 'getAllGenres']);
    Route::post('/', [GenresController::class, 'createGenre']);
});
