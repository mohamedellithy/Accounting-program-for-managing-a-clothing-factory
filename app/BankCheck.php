<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    "merchant" => 'App\merchant',
    "client" => 'App\client',
]);
class BankCheck extends Model
{
    //
    protected $fillable = [
        'bank_checkable_id','bank_checkable_type','check_date','check_value','increase_value','check_owner','payed_check'
    ];

    public function bank_checkable()
    {
        return $this->morphTo();
    }
}
