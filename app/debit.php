<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    "merchant" => 'App\merchant',
    "client" => 'App\client',
    "suppliers" => 'App\suppliers',
]);

class debit extends Model
{
    //

       //
    protected $fillable = [
        'debitable_id','debitable_type','debit_value','debit_type','payed_check','type_payment','debit_name','order_id',
    ];

    public function debit_checkable()
    {
        return $this->morphTo();
    }
}
