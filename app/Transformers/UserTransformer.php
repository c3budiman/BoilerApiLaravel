<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;
use App\Transformers\PostTransformer;
use App\Post;

class UserTransformer extends TransformerAbstract {
  protected $availableIncludes = [
    'posts'
  ];

  //ini fungsi transformer gunanya biar seragamin respon, jadi klo ganti variabel atau kolom di db, response kagak diganti
  //jadi frontend designer bisa bernapas lega.... karena klo backend ngeganti kolom di db, data kagak ke ganti di frontend
  public function transform(User $user) {
    return [
      'id'         =>  $user->id,
      'nama'       =>  $user->name,
      'email'      =>  $user->email,
      'registered' =>  $user->created_at->diffForHumans()
    ];
  }

  public function includePosts(User $user) {
    $post = $user->posts()->MudaDuluan()->get();
    return $this->collection($post, new PostTransformer);
  }
}
