<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class AuthController extends Controller
{
    //fungsi ini untuk mendaftarkan user, dan mendapatkan api_token yang digunakan buat login
    public function register(Request $request, User $user){
      //validasi request
      $this->validate($request, [
        'name'      => 'required',
        'email'     => 'required|email|unique:users',
        'password'  => 'required|min:6',
      ]);

      //mass asignment ke database
      $createuser = $user->create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => bcrypt($request->password),
        'api_token' => bcrypt($request->name.$request->email)
      ]);

      //membuat response array, untuk di tampilkan menjadi json nantinya
      $response = fractal()
                            ->item($createuser)
                            ->transformWith(new UserTransformer)
                            ->addMeta([
                              'token' => $createuser->api_token,
                            ])
                            ->toArray();
      //endpoint api berdasarkan hasil dari response, jika berjalan lancar :
      // 201, artinya konten berhasil dibuat, 200 success, 404 not found, 500 server error etc etc...
      return response()->json($response,201);
    }

    //fungsi ini buat login dengan menggunakan email dan password biar dapat api_token
    public function login(Request $request, User $user){
      //dibawah kodingan untuk cek email dan password yg diberikan di header body, apakah match ama yg ada di db atau tidak
      //kalo tidak kita kasih response 401 alias unauthorized
      if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
          return response()->json(['error' => 'Your Credential Is Wrong!! Bitch...'], 401);
      }
      //kalo matching, kita cari id user nya, stor ke variabel user
      $user = $user->find(Auth::user()->id);

      //terakhir kita jadikan response json buat endpoint ke aplikasi yg lain.....
      return fractal()
                      ->item($user)
                      ->transformWith(new UserTransformer)
                      ->addMeta([
                        'token' => $user->api_token,
                      ])
                      ->toArray();
    }
}
