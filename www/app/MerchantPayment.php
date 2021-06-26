<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantPayment extends Model
{
    //

    protected $fillable = [
       'merchant_id','value',
    ];

    public function merchant(){
        return $this->belongsTo('App\merchant','merchant_id','id');
    }
}
