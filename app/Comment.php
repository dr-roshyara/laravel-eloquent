<?php

namespace App;
use App\Post;
use App\Likable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use Likable;
    //
    public function post(){
        return $this->belongsTo(Post::class);
    }
     
 
}
