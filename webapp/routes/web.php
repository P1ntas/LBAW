<?php

// Authentication
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('/login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('/logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('/register');
Route::post('/register', 'Auth\RegisterController@register');

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