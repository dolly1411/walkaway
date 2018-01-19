<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public function place(){
        return $this->belongsTo('App\Place');
    }
     
    public function activity(){
        return $this->belongsTo('App\Activity');
    }

     public function asset(){
        return $this->belongsTo('App\Asset');
    }

}
