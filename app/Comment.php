<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = array('id');
    public static $rules = array(
        'goods_id' => 'required',
        'comment' => 'required',
        );
        
        
    public function goods(){
    return $this->belongsTo('App\Goods');
    }
}
