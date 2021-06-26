<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClothStyles extends Model
{
    //

    protected $fillable = [
        'order_clothes_id','supplier_id','name_piecies','count_piecies','price_piecies' ,'additional_taxs','full_price'
    ];

    public function orders(){
        #order_clothes
        return $this->belongsTo('App\orderClothes','order_clothes_id','id');
    }

    public function products(){
        return $this->hasOne('App\product','cloth_styles_id','id');
    }
}
