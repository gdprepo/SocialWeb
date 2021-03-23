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


Route::get('/post/add', [App\Http\Controllers\HomeController::class, 'postAdd'])->name('post.add');

Route::post('/post/add/store', [App\Http\Controllers\HomeController::class, 'postStore'])->name('post.add');



Route::post('/like', [App\Http\Controllers\PostController::class, 'like'])->name('posts.like');
Route::post('/post/show/like', [App\Http\Controllers\PostController::class, 'like'])->name('postShow.like');

//Route::post('/posts/{hashtag}/like', [App\Http\Controllers\PostController::class, 'like'])->name('postsHash.like');







Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('login_fb');
Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('auth/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);



Route::get('/user/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

