<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', 'Auth\LoginController@getUser');

