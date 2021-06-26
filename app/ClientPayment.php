<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    //

    protected $fillable = [
       'client_id','date','value',
    ];

    public function client(){
        return $this->belongsTo('App\client','client_id','id');
    }
}
