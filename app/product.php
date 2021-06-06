<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    protected $fillable = [
        'name_product','category_id','cloth_styles_id','name_piecies','count_piecies','price_piecies','additional_taxs','full_price',
    ];

    public function clothes_styles(){
        return $this->belongsTo('App\ClothStyles','cloth_styles_id','id');
    }

    public function category_name(){
        return $this->belongsTo('App\category','category_id','id');
    } 
}
