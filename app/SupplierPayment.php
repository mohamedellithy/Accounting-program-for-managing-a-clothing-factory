<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    //

    protected $fillable = [
       'supplier_id','value',
    ];

    public function supplier(){
        return $this->belongsTo('App\supplier','supplier_id','id');
    }
}
