<?php

namespace App;
use App\User;
use App\Post;
use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    //
     public function posts (){
         return $this->hasManyThrough(Post::class, User::class);
     }
}
