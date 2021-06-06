<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class postponed extends Model
{
    //

    protected $fillable = [
       'client_id','posponed_date','posponed_value','posponed_finished',
    ];

     public function client(){
        return $this->belongsTo('App\client','client_id','id');
    } 
}
