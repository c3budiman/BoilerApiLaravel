<?php
namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Post;

class PostTransformer extends TransformerAbstract {

  //ini fungsi transformer gunanya biar seragamin respon, jadi klo ganti variabel atau kolom di db, response kagak diganti
  //jadi frontend designer bisa bernapas lega....
  public function transform(Post $post) {
    return [
      'id'          => $post->id,
      'post'     => $post->post,
      'published'   => $post->created_at->diffForHumans(),
      'LastUpdate'  => $post->updated_at->diffForHumans(),
    ];
  }


}
