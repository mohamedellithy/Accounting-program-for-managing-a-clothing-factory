<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class withdraw extends Model
{
    //

    protected $fillable = [
         'partner_id','withdraw_value','profit_value','type_withdraw'
    ];


    public function partners(){
        return $this->belongsTo('App\partners','partner_id','id');
    } 
}
