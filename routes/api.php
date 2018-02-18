<?php

use Illuminate\Http\Request;


//cara menggunakan cukup, method get. lalu diisi dengan domain.com/api/users
//nanti otomatis dia me list users yang terdaftar
Route::get('users', 'PenggunaController@getUsers');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController2@login');
    Route::post('logout', 'AuthController2@logout');
    Route::post('refresh', 'AuthController2@refresh');
    //Route::post('me', 'AuthController2@me');
});
//login, cara pakai :
//method post, alamat domain.com/api/auth/login, lalu header accept, application/json
//kemudian isi body nya :
//{ "email" : "uremail@gmail.com", "password" : "urpassword" }
//lalu send request. api akan merespon dengan token, simpan token nya buat digunakan nanti


//logout, cara pakai :
//method post, domain.com/api/auth/logout, lalu header accept, application/json
//header lagi authorization, isi Bearer <spasi> TokenUser
//kirim request api, api akan merespon dengan status. dan token akan terdelete

//refresh, cara pakai sama kayak logout.
//beda nya token lama di delete lalu diganti, dan ditampilkan token baru nya

//me deprecated. use api/user/profile

//bagian bikinan sendiri...
//membutuhkan token dari login atau register untuk akses
Route::middleware('auth:api')->group(function () {
  Route::get('user/profile', 'PenggunaController@getProfil');
  Route::get('user/{id}', 'PenggunaController@getProfilById');
  Route::post('post', 'postController@add');
  //overloading function on put and delete, supposed to be {id} but that is for the weak...
  Route::put('post/{post}', 'postController@update');
  Route::delete('post/{post}', 'postController@delete');
});


//userprofile cara pakai :
//method get, domain.com/api/user/profile, lalu header accept, application/json
//header lagi, authorization, isi Bearer <spasi> TokenUser
//kirim request api, api akan merespon dengan informasi mengenai user tersebut

//user{id}
//method get, domain.com/api/user/<isi dengan id user ex : 1>, lalu header accept, application/json
//header lagi, authorization, isi Bearer <spasi> TokenUser
//kirim request api, api akan merespon dengan informasi mengenai user tersebut, dan postingan apa yg telah ia buat

//posting post cara pakai :
//method post, domain.com/api/post, lalu header accept, application/json
//header lagi, authorization, isi Bearer <spasi> TokenUser
//isi body dengan json, contoh nya :
// {
//   "post" : "saya lagi ngoding sekarang..."
// }
//kirim request api, jika sukses konten akan masuk database, dan dapat kiriman response json 201

//update post, cara pakai :
//method put, domain.com/api/post/<isi dengan id post ex : 1>, lalu header accept, application/json
//header lagi, authorization, isi Bearer <spasi> TokenUser
//isi body dengan json, contoh nya :
// {
//   "post" : "saya lagi ngoding tadi..."
// }
//kirim request api, jika sukses konten akan diupdate di database, dan dapat kiriman response json

//delete post, cara pakai :
//method delete, domain.com/api/post/<isi dengan id post ex : 1>, lalu header accept, application/json
//header lagi, authorization, isi Bearer <spasi> TokenUser
//kirim request api, jika sukses konten akan hilang di db,
//dan dapat kiriman response json menyatakan post berhasil di delete




// deprecated.... no longer needed maybe deleted later.. or not
//it is depend on situation whether to use lifetime token without jwt or not
// Route::post('auth/register','AuthController@register');
// Route::post('auth/login','AuthController@login');
//
