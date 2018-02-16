<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Transformers\PostTransformer;
use Auth;

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


}
