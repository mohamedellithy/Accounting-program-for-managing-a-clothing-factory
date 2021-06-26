<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
class product extends Model
{
    //
    protected $fillable = [
        'parcode','name_product','category_id','cloth_styles_id','name_piecies','count_piecies','price_piecies','additional_taxs','full_price',
    ];

    public function clothes_styles(){
        return $this->belongsTo('App\ClothStyles','cloth_styles_id','id');
    }

    public function orders(){
        return $this->hasMany('App\order','product_id','id');
    }

    public function category(){
        return $this->belongsTo('App\category','category_id','id');
    }

    public function ScopeFinished($query){
        #Finished
        return $query->where('count_piecies',0);
    }

    public function ScopeAlmostFinished($query){
        #AlmostFinished
        return $query->whereBetween('count_piecies',array(0,20));
    }

    public function  getTotalCostAttribute(){
        # total_cost
        return ( $this->count_piecies * $this->price_piecies ) + ( $this->count_piecies * $this->additional_taxs );
    }

    public function  getProductPriceAttribute(){
        # product_price
        return $this->price_piecies +  $this->additional_taxs;
    }

    public function getParcodeUrlAttribute(){
        #Parcode_Url
        $url = URL::to("parcode-product/$this->parcode");
        return $url;
    }


}
