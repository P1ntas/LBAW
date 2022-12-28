<?php

// Static Pages
Route::get('/', 'StaticController@home');
Route::get('/about', 'StaticController@home');
Route::get('/contacts', 'StaticController@contacts');
Route::get('/faq', 'StaticController@faq');

// Authentication
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('/login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('/logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('/register');
Route::post('/register', 'Auth\RegisterController@register');

// Books
Route::get('/books', 'BookController@list');
Route::get('/books/add', 'BookController@addBook');
Route::get('/books/{id}', 'BookController@show')->where(['id' => '[0-9]+']);
Route::get('/books/{id}/edit', 'BookController@edit')->where(['id' => '[0-9]+']);

// Categories
Route::get('/categories', 'CategoryController@list');

// Users
Route::get('/users', 'UserController@list');
Route::post('/users/search', 'UserController@search');
Route::get('/users/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('/users/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);

// Admins
Route::get('/admins/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('/admins/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);

// Purchases
Route::get('/users/{id}/purchases', 'PurchaseController@listByUser')->where(['id' => '[0-9]+']);

// Cart
Route::get('/users/{id}/cart', 'UserController@shoppingCart')->where(['id' => '[0-9]+']);
Route::get('/users/{id}/cart/checkout', 'UserController@checkoutInfo')->where(['id' => '[0-9]+']);

// Wishlist
Route::get('/users/{id}/wishlist', 'UserController@wishlist')->where(['id' => '[0-9]+']);