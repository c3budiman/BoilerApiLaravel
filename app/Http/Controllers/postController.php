<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Transformers\PostTransformer;
use Auth;
use App\User;

//kontroller yang mengatur postingan, anggap saja begitu...
class postController extends Controller
{
  //menambahkan postingan
  public function add(Request $request, post $post) {
    //validasi
    $this->validate($request, [
      'post' => 'required|min:10',
    ]);
    //mass assignment
    $post = $post->create([
      'author'  => Auth::user()->id,
      'post' => $request->post,
    ]);
    //panggil kelas transformer, lalu hasilkan array json.
    $response = fractal()
                ->item($post)
                ->transformWith(new PostTransformer)
                ->toArray();
    //hasil yg di jadikan api :
    return response()->json($response,201);
  }

  //yg bawah ini dia nyari post berdasar id dari parameter yg di overloading dari route.... berdasarkan id
  public function update(Request $request, Post $post) {

    //ini untuk cek otorisasi, apakah user yg hendak post adalah yg punya post atau bukan
    //class yg di pake di postpolicy, dan authpolicy
    $this->authorize('update',$post);

    //ini buat nge set nilai yg baru lalu di save ke db
    //parameter ke dua berguna saat blank request, post tidak terupdate blank
    $post->post = $request->get('post', $post->post);
    $post->save();

    //return response json array pos sudah berhasil di update
    return fractal()
    ->item($post)
    ->transformWith(new PostTransformer)
    ->toArray();
  }

  //overloading juga gan biar ga cape bikin fungsi lagi buat nyari pos mana yg harus di delete
  public function delete(Post $post) {
    //sama seperti di update otorisasi, berhak tidak user mendelete berdasarkan pemilik pos nya
    //sama ada di postpolicy sama authpolicy
    $this->authorize('update',$post);

    //cara nge delete post simple kan....
    $post->delete();

    //ini buat return response dalam bentuk json, supaya app, atau pengguna api bisa tau klo sudah di delete sukses
    return response()->json([
      'status' => '200',
      'message' => 'Deleted',
    ]);
  }


}
