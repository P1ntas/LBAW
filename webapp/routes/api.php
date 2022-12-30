<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');

// Users
Route::post('/users/{id}/edit', 'UserController@update')->where(['id' => '[0-9]+']);

