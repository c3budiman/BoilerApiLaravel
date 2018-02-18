<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    //this one mean u can mass assignment using create(['name'=>$value etc etc])
    protected $fillable = [
        'name', 'email', 'password',
    ];

    //this one mean u cant get the column data if u call the model value array
    protected $hidden = [
        'password', 'remember_token',
    ];

    //ini fungsi dari jwt, buat key dan claims idk wut is this...
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    //disini simple nya relasi dari post itu mempunyai banyak data author dari user,
    //namun single value nya ada di post
    public function posts() {
      return $this->hasMany('App\Post', 'author');
    }

    public function ownsPost(Post $post) {
      return auth()->id() === $post->author;
    }
}
