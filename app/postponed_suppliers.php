<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class postponed_suppliers extends Model
{
    //


    protected $fillable = [
       'supplier_id','posponed_value',
    ];

    public function orderClothes(){
        return $this->belongsTo('App\suppliers','supplier_id','id');
    } 
}
