<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //
    public function videos(){
        return $this->morphMany(Video::class, 'watchable'); 
 }
}
  