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

    public function debit()
    {
        return $this->morphMany(debit::class, 'debitable');
    }
}
