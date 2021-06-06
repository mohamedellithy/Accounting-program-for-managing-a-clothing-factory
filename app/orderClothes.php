<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderClothes extends Model
{
    //
    protected $fillable = [
        'merchant_id','category_id','order_size_type','order_size','order_price','order_discount','payment_type','price_one_piecies','order_follow','order_finished',
    ];


    public function bank_check()
    {
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

    public function merchant_name(){
        return $this->belongsTo('App\merchant','merchant_id','id');
    } 

     public function category_name(){
        return $this->belongsTo('App\category','category_id','id');
    } 

    public function postponeds_money(){
        return $this->hasMany('App\postponed_orderClothes','orderClothes_id','id');
    } 
}
