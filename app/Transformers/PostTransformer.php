<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Post;
use App\User;
use DB;

class PostTransformer extends TransformerAbstract {

  //ini fungsi transformer gunanya biar seragamin respon, jadi klo ganti variabel atau kolom di db, response kagak diganti
  //jadi frontend designer bisa bernapas lega....
  public function transform(Post $post) {
    $namaAuthor = DB::table('users')->where('id','=',$post->author)->get()->first()->name;
    return [
      'id'          => $post->id,
      'author'      => $namaAuthor,
      'post'        => $post->post,
      'published'   => $post->created_at->diffForHumans(),
      'LastUpdate'  => $post->updated_at->diffForHumans(),
    ];
  }




}
