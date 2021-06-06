<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class postponed_orderClothes extends Model
{
    //


    protected $fillable = [
       'merchant_id','posponed_value',
    ];

    public function merchant(){
        return $this->belongsTo('App\merchant','merchant_id','id');
    } 
}
