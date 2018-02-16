<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class PenggunaController extends Controller
{
    //membuat get api untuk menampilkan semua user, tanpa token
    public function getUsers(User $user){
      $users = $user->all();
      return fractal()
                      ->collection($users)
                      ->transformWith(new UserTransformer)
                      ->toArray();
    }

    //membuat get api, untuk menampilkan profil salah satu user, user harus login dengan token terlebih dahulu
    public function getProfil(User $user){
      $user = $user->find(Auth::user()->id);
      return fractal()->item($user)
                      ->transformWith(new UserTransformer)
                      ->toArray();
    }
}
