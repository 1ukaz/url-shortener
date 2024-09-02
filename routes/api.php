<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UrlShortenController;
use App\Http\Controllers\UrlListController;
use App\Http\Controllers\UrlRedirectController;
use App\Http\Controllers\UrlDeleteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', UrlController::class);
Route::post('/shorten', UrlShortenController::class);
Route::get('/list', UrlListController::class);
Route::get('/{code}', UrlRedirectController::class);
Route::delete('/{code}', UrlDeleteController::class);
