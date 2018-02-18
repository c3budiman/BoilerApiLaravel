<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
  //menspecify table mana yg digunakan
  protected $table = 'post';
  //untuk mass asignment di laravel, kita perlu definisikan kolom nya disini
  protected $fillable = [
    'author','post',
  ];

  public function scopeMudaDuluan($query) {
    return $query->orderBy('id', 'DESC');
  }

  public function user() {
    $this->belongsTo(User::class);
  }
}
