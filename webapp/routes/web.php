<?php

// Authentication
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('/login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('/logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('/register');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/forgot-password', 'UserController@forgot')->middleware('guest')->name('password.request');
Route::post('/forgot-password', 'UserController@forgotPassword')->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', 'UserController@reset')->middleware('guest')->name('password.reset');
Route::post('/reset-password', 'UserController@resetPassword')->middleware('guest')->name('password.update');

// Static Pages
Route::get('/', 'StaticController@home');
Route::get('/about', 'StaticController@about');
Route::get('/contacts', 'StaticController@contacts');
Route::get('/faq', 'StaticController@faq');

// Books
Route::get('/books', 'BookController@list');
Route::get('/books/{id}', 'BookController@show')->where(['id' => '[0-9]+']);
Route::post('/books/filter', 'BookController@filter');
Route::post('/books/search', 'BookController@search');

// Categories
Route::get('/categories', 'CategoryController@list');

// Users
Route::get('/users/{id}', 'UserController@show')->where(['id' => '[0-9]+']);