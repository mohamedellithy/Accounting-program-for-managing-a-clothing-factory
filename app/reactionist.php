<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reactionist extends Model
{
    //

    protected $fillable = [ 
        'client_id','product_id','order_id','reactionist_price','payment_type','order_count','final_cost',
    ];


     public function product_name(){
        return $this->belongsTo('App\product','product_id','id');
    } 

    public function order_name(){
        return $this->belongsTo('App\order','order_id','id');
    } 

     public function client_name(){
        return $this->belongsTo('App\client','client_id','id');
    } 
}
