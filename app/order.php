<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //

    protected $fillable = [
         'client_id','product_id','order_discount','order_taxs','order_price','payment_type','order_count','final_cost','order_follow',
    ];

    public function product_name(){
        return $this->belongsTo('App\product','product_id','id');
    } 

     public function client_name(){
        return $this->belongsTo('App\client','client_id','id');
    } 

  
    public function postponeds_money(){
        return $this->hasMany('App\postponed','order_id','id');
    } 

    
}
