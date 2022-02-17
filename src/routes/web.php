<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/login', [App\Http\Controllers\CookieAuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\CookieAuthenticationController::class, 'logout'])->name('logout');
