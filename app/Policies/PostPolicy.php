<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    //kita menggunakan fungsi ownsPost untuk mencari apakah si user ini punya post ini berdasar relasi
    public function update(User $user, Post $post) {
      return $user->ownsPost($post);
    }

    public function delete(User $user, Post $post) {
      return $user->ownsPost($post);
    }
}
