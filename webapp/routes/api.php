<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');

// Users
Route::post('/users/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);

// Admins
Route::post('/admins/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);

// Cart
Route::get('/users/{id}/cart/clear', 'UserController@clearCart')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/cart', 'UserController@manageCart')->where(['id' => '[0-9]+']);

// Wishlist
Route::get('/users/{id}/wishlist/clear', 'UserController@clearWishlist')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/wishlist', 'UserController@manageWishlist')->where(['id' => '[0-9]+']);

// Books
Route::post('/books/{id}', 'UserController@addToCart')->where(['id' => '[0-9]+']);
Route::post('/books/{id}', 'UserController@addToWishlist')->where(['id' => '[0-9]+']);
//Route::post('/books/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);

// Purchases
Route::post('/users/{id}/cart/checkout', 'PurchaseController@checkout')->where(['id' => '[0-9]+']);
