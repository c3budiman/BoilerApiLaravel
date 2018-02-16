<?php

use Illuminate\Http\Request;

Route::get('users', 'PenggunaController@getUsers');
Route::post('auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');

//membutuhkan token dari login atau register untuk akses
Route::middleware('auth:api')->group(function () {
  Route::get('user/profile', 'PenggunaController@getProfil');
  Route::post('post', 'postController@add');
});
