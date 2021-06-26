<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class suppliers extends Model
{
    //
    protected $fillable=[
      'supplier_name','supplier_phone',
    ];

    public function clothes_styles(){
        return $this->hasMany('App\ClothStyles','supplier_id','id');
    }

    public function payments(){
        return $this->hasMany('App\SupplierPayment','supplier_id','id');
    }

    public function debit()
    {
        return $this->morphMany(debit::class, 'debitable');
    }

    function getTotalCostAttribute(){
        #total_cost
        return $this->clothes_styles->sum(function($self){
            return $self->additional_taxs * $self->count_piecies;
        });
    }

    function getTotalSupplierPaidAttribute(){
        #total_supplier_paid
        return $this->payments->sum('value');
    }

    function getTotalSupplierNotPaidAttribute(){
        #total_supplier_not_paid
        return $this->total_cost - $this->total_supplier_paid;
    }

    function getTotalSupplierDebitAttribute(){
        #total_supplier_debit
        return $this->debit->sum('debit_value');
    }
}
