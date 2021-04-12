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

Route::get('/{hashtag?}', [App\Http\Controllers\HomeController::class, 'postHashtag'])->name('postHashtag');


Route::get('/profile/info/{id?}', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::get('/post/show/{id}', [App\Http\Controllers\PostController::class, 'postShow'])->name('post.show');

Route::get('/product/show/{id}', [App\Http\Controllers\PostController::class, 'productShow'])->name('product.show');


Route::get('/post/add', [App\Http\Controllers\HomeController::class, 'postAdd'])->name('post.add');

Route::post('/post/add/store', [App\Http\Controllers\HomeController::class, 'postStore'])->name('post.add');


Route::get('/product/add', [App\Http\Controllers\HomeController::class, 'productAdd'])->name('product.add');

Route::post('/product/add/store', [App\Http\Controllers\HomeController::class, 'productStore'])->name('product.store');



Route::post('/like', [App\Http\Controllers\PostController::class, 'like'])->name('posts.like');
Route::post('/post/show/like', [App\Http\Controllers\PostController::class, 'like'])->name('postShow.like');

//Route::post('/posts/{hashtag}/like', [App\Http\Controllers\PostController::class, 'like'])->name('postsHash.like');


Route::get('/notifications/all', [App\Http\Controllers\HomeController::class, 'notifications'])->name('notifications');


Route::get('/cart/checkout/{id?}', [App\Http\Controllers\CartController::class, 'index'])->name('cart.checkout');
Route::get('/cart/checkout/delete/{id?}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.delete');

Route::get('/cart/add/{id?}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');


Route::get('/settings/api', [App\Http\Controllers\HomeController::class, 'settings'])->name('params');
Route::post('/settings/stripe/upd', [App\Http\Controllers\HomeController::class, 'settingsStripe'])->name('params.upd');





Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('login_fb');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('auth/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);



Route::get('/user/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

