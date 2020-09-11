<?php 
namespace App;
use App\Like;

trait Likable{ 
    
    public function like($user=null){
        $user = $user ?: auth()->user();
         return $this->likes()->attach($user);
 
     }
     public function likes(){ 
             return $this->morphToMany(User::class,'likable')->withTimeStamps();
     }
 
}