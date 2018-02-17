<?php

use Illuminate\Http\Request;

Route::get('users', 'PenggunaController@getUsers');
// Route::post('auth/register','AuthController@register');
// Route::post('auth/login','AuthController@login');
//
//membutuhkan token dari login atau register untuk akses
Route::middleware('auth:api')->group(function () {
  Route::get('user/profile', 'PenggunaController@getProfil');
  Route::post('post', 'postController@add');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController2@login');
    Route::post('logout', 'AuthController2@logout');
    Route::post('refresh', 'AuthController2@refresh');
    Route::post('me', 'AuthController2@me');
});
