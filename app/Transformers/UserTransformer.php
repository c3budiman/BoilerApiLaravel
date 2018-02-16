<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {
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
}
