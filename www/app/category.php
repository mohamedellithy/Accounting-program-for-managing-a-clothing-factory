<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //

    protected $fillable = [
        'category',
    ];

    public function order_clothes(){
        return $this->hasMany('App\orderClothes','category_id','id');
    }

    public function products(){
        return $this->hasMany('App\product','category_id','id');
    }


}
