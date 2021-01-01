<?php

use App\Http\Controllers\Desktop\DiscogsController;
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
