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
        'debitable_id','debitable_type','debit_value','debit_type','debit_paid','type_payment','debit_name','order_id',
    ];

    public function debitable()
    {
        return $this->morphTo();
    }

    public function ScopeDebit($query){
        #Debit
       return $query->where('debit_type','مدين');
    }

    public function ScopeCredit($query){
        #Credit
       return $query->where('debit_type','دائن');
    }

    public function getDebitForAttribute(){
        # debit_for
        if($this->debitable_type == 'client')       return 'عملاء';
        elseif($this->debitable_type == 'merchant') return 'تاجر';
        return 'مصنع';
    }

    public function getRestValueOfDebitAttribute(){
        # rest_value_of_debit
        return $this->debit_value - $this->debit_paid;
    }
}
