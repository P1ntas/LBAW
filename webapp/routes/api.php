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

// Cart
Route::get('/users/{id}/cart', 'UserController@clearCart')->where(['id' => '[0-9]+']);
Route::post('/users/{id}/cart', 'UserController@manageCart')->where(['id' => '[0-9]+']);
