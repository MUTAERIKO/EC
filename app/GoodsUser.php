<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsUser extends Model
{
    protected $table = 'goods_user';
    
    public function goods(){
        return $this->belongsTo('App\Goods');
    }
}



