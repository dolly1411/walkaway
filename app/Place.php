<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function tip(){
    	return $this->hasMany('App\Tip');
    }

    public function asset(){
    	return $this->hasMany('App\Asset');
    }
}
