<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reactionist extends Model
{
    //

    protected $fillable = [
        'order_id','one_item_price','payment_type','order_count','profit_order','final_cost',
    ];

    public function order(){
        return $this->belongsTo('App\order','order_id','id');
    }
}
