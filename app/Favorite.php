<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $guarded = array('id');
    protected $table = 'goods_user';
        
    public function goods()
    {
        return $this->belongsToMany('App\Goods');
    }
}
