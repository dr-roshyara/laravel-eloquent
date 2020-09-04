<?php

namespace App;
use App\User;
use App\Comment;
use App\Tag;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps(); 
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
