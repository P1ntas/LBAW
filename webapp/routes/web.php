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
Route::get('/users/{id}', 'UserController@show')->where(['id' => '[0-9]+'])->name('pages.user');;
Route::get('/users/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);
Route::put('/users/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);
Route::delete('/users/{id}/delete', 'UserController@delete')->where(['id' => '[0-9]+']);

// Cart
Route::get('/users/{id}/cart', 'UserController@shoppingCart')->where(['id' => '[0-9]+']);
Route::delete('/users/{user_id}/cart/{book_id}', 'UserController@manageCart')->where(['user_id' => '[0-9]+', 'book_id' => '[0-9]+']);
Route::delete('/users/{id}/cart/clear', 'UserController@clearCart')->where(['id' => '[0-9]+']);
Route::get('/books/{book_id}/cart', 'UserController@addToCart')->where(['book_id' => '[0-9]+']);

// Purchases
Route::get('/users/{id}/purchases', 'PurchaseController@list')->where(['id' => '[0-9]+']);
Route::delete('/users/{user_id}/purchases/{purchase_id}/cancel', 'PurchaseController@cancelOrder')->where(['user_id' => '[0-9]+', 'purchase_id' => '[0-9]+']);
Route::get('/users/{id}/cart/checkout', 'PurchaseController@checkout')->where(['id' => '[0-9]+']);

// Wishlist
Route::get('/users/{id}/wishlist', 'UserController@wishlist')->where(['id' => '[0-9]+']);
Route::delete('/users/{user_id}/wishlist/{book_id}', 'UserController@manageWishlist')->where(['user_id' => '[0-9]+', 'book_id' => '[0-9]+']);
Route::get('/books/{book_id}/wish', 'UserController@addToWishlist')->where(['book_id' => '[0-9]+']);

// Reviews
Route::post('/books/{id}/review', 'BookController@review')->where(['id' => '[0-9]+']);
Route::delete('/books/{book_id}/review/{review_id}/remove', 'BookController@removeReview')->where(['book_id' => '[0-9]+', 'review_id' => '[0-9]+']);
Route::put('/books/{book_id}/review/{review_id}/edit', 'BookController@editReview')->where(['book_id' => '[0-9]+', 'review_id' => '[0-9]+']);

// Admins
Route::get('/admins/{id}', 'UserController@show')->where(['id' => '[0-9]+']);
Route::get('/admins/{id}/edit', 'UserController@edit')->where(['id' => '[0-9]+']);
Route::put('/admins/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);
Route::delete('/admins/{id}/delete', 'UserController@delete')->where(['id' => '[0-9]+']);
Route::get('/users', 'UserController@list')->where(['id' => '[0-9]+']);
Route::post('/users/search', 'UserController@search');
Route::put('/users/{user_id}/purchases/{purchase_id}/status', 'PurchaseController@updateStatus')->where(['user_id' => '[0-9]+', 'purchase_id' => '[0-9]+']);
Route::get('/books/add', 'BookController@add');
Route::post('/books/add', 'BookController@create');
Route::get('/books/{id}/edit', 'BookController@edit')->where(['id' => '[0-9]+']);
Route::put('/books/{id}/edit', 'BookController@update')->where(['id' => '[0-9]+']);
Route::delete('/books/{id}/remove', 'BookController@delete')->where(['id' => '[0-9]+']);