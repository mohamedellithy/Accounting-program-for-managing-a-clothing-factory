<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class merchant extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_name', 'merchant_phone',
    ];

     public function bank_check()
    {
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

    public function order_clothes(){
        return $this->hasMany('App\orderClothes','merchant_id','id');
    }

    public function Cloth_Orders(){
        return $this->hasMany('App\orderClothes','merchant_id','id');
    }


    public function debits()
    {
        return $this->morphMany(debit::class, 'debitable');
    }

    public function debits_payed()
    {
        return $this->morphMany(debit::class, 'debitable')->where('debit_paid','!=',0);
    }

    public function debits_not_payed()
    {
        return $this->morphMany(debit::class, 'debitable')->where('debit_paid',0);
    }

    public function Paid(){
         return $this->hasMany('App\MerchantPayment','merchant_id','id');
    }
}
