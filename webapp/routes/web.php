<?php

// Home
Route::get('/', 'StaticController@index');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Books
Route::get('books', 'BookController@list');
Route::post('books/search', 'BookController@search');
Route::get('books/{id}', 'BookController@show')->where(['id' => '[0-9]+']);
Route::get('books/{id}/edit', 'BookController@edit')->where(['id' => '[0-9]+']);

// Users
Route::get('users', 'UserController@list');
Route::post('users/search', 'UserController@search');
Route::get('users/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('users/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);

// Admins
Route::get('admins/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('admins/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);

// Purchases
Route::get('users/{id}/purchases', 'PurchaseController@listByUser')->where(['id' => '[0-9]+']);

// Cart
Route::get('users/{id}/cart', 'UserController@shoppingCart')->where(['id' => '[0-9]+']);
Route::get('users/{id}/cart/checkout', 'UserController@checkoutInfo')->where(['id' => '[0-9]+']);

// Wishlist
Route::get('users/{id}/wishlist', 'UserController@wishlist')->where(['id' => '[0-9]+']);

// About us
Route::get('about', 'StaticController@about');

// FAQ
Route::get('faq', 'StaticController@faq');

// Contacts
Route::get('contacts', 'StaticController@contacts');