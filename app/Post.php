<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  //menspecify table mana yg digunakan
  protected $table = 'post';
  //untuk mass asignment di laravel, kita perlu definisikan kolom nya disini
  protected $fillable = [
    'author','post',
  ];
}
