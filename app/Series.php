<?php

namespace App;
use App\videos;

use Illuminate\Database\Eloquent\Model; 
use App\Video;
class Series extends Model
{
    //
     public function videos(){
            return $this->morphMany(Video::class, 'watchable'); 
     }
}
