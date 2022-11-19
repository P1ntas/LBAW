<?php

// Home
Route::get('/', 'HomeController@show');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Books
Route::get('books', 'BookController@list');
Route::get('books/{id}', 'BookController@show')->where(['id' => '[0-9]+']);

// Users
Route::get('/users', 'UserController@list');
Route::get('/users/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('/users/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);

// Purchases
Route::get('/users/{id}/purchases', 'PurchaseController@listByUser')->where(['id' => '[0-9]+']);

// Cart
Route::get('/users/{id}/cart', 'UserController@shoppingCart')->where(['id' => '[0-9]+']);
