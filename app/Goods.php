<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
        'image' => 'required',
        'title' => 'required',
        'price' => 'required',
        'intro' => 'required',
        );
        
        public function comments(){
        return $this->hasMany('App\Comment');
        }
        
        public function users(){
        return $this->belongsToMany('App\User');
    }
    
        public function histories(){
        return $this->hasMany('App\History');
    }
}
