<?php

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', App\Http\Controllers\MeController::class)->name('user.me');

    Route::apiResource('cats', App\Http\Controllers\CatController::class)
        ->except(['create', 'edit']);
//    Route::apiResource('feeds', App\Http\Controllers\FeedController::class)
//        ->except(['create', 'edit']);
//    Route::apiResource('food_catalogs', App\Http\Controllers\FoodCatalogController::class)
//        ->except(['create', 'edit']);
//
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


