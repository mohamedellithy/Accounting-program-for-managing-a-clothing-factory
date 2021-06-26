<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    //
    protected $fillable = [
         'partner_id','value',
    ];

    public function Partner(){
        return $this->belongsTo('App\Partner','partner_id','id');
    }
}
