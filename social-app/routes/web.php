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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile/{id?}', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('login_fb');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

