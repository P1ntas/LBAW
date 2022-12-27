<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');

// Users
Route::post('/users/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);
Route::get('/users/{id}/delete', 'UserController@delete')->where(['id' => '[0-9]+']);

// Admins
Route::post('/admins/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);

// Cart
Route::get('/users/{id}/cart/clear', 'UserController@clearCart')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/cart', 'UserController@manageCart')->where(['id' => '[0-9]+']);

// Wishlist
Route::get('/users/{id}/wishlist/clear', 'UserController@clearWishlist')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/wishlist', 'UserController@manageWishlist')->where(['id' => '[0-9]+']);

// Books
Route::post('/books/search', 'BookController@search');
Route::post('/books/add', 'BookController@create');
Route::post('/books/{id}/cart', 'UserController@addToCart')->where(['id' => '[0-9]+']);
Route::post('/books/{id}/wish', 'UserController@addToWishlist')->where(['id' => '[0-9]+']);
Route::post('/books/{id}/edit', 'BookController@update')->where(['id' => '[0-9]+']);
Route::post('/books/{id}/review', 'BookController@review')->where(['id' => '[0-9]+']);
Route::post('/books/{id}/review/remove', 'BookController@removeReview')->where(['id' => '[0-9]+']);

// Categories
Route::post('/categories/search', 'CategoryController@search');
Route::post('/categories/add', 'CategoryController@create');
Route::get('/categories/{id}/remove', 'CategoryController@delete')->where(['id' => '[0-9]+']);

// Purchases
Route::post('/users/{id}/cart/checkout', 'PurchaseController@checkout')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/purchases/cancel', 'PurchaseController@cancelOrder')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/purchases/status', 'PurchaseController@updateStatus')->where(['id' => '[0-9]+']);
