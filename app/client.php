<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    //

    protected $fillable = [
        'client_name', 'client_phone',
    ];


     public function order_products(){
        return $this->hasMany('App\order','client_id','id');
    } 

      public function bank_check()
    {
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

     public function debit()
    {
        return $this->morphMany(debit::class, 'debitable');
    }
}
