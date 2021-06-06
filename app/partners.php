<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class partners extends Model
{
    protected $fillable = [
         'partner_name','partner_phone','partner_percentage','partner_percent','partner_ended_at','partner_status',
    ];

    //

    public function withdraw(){
        return $this->hasMany('App\withdraw','partner_id','id');
    } 
}
