<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    //

    protected $fillable = [
        'client_name', 'client_phone',
    ];


    public function order_products(){
        return $this->hasMany('App\order','client_id','id');
    }

    public function bank_check()
    {
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

    public function debit()
    {
        return $this->morphMany(debit::class, 'debitable');
    }

    public function bank_cheque()
    {
        # bank_cheque
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

    public function payments(){
        return $this->hasMany('App\ClientPayment','client_id','id');
    }

    public function getInvoicesOrdersAttribute(){
        #invoices_orders
        return $this->order_products()->where('order_follow',null)->get();
    }

    public function getTotalInvoicesAttribute(){
        #total_invoices
        return $this->order_products()->sum('final_cost');
    }

    public function getClientPaidAttribute(){
        #client_paid
        return $this->order_products()->sum('final_cost');
    }

    public function getTotalPaymentsAttribute(){
        #total_payments
        return $this->payments()->sum('value');
    }

    public function getTotalInvoicesCacheAttribute(){
        #total_invoices_cache
        return $this->order_products()->where('payment_type','نقدى')->sum('final_cost');
    }

    public function getTotalInvoicesNotCacheAttribute(){
        #total_invoices_not_cache
        return $this->order_products()->where('payment_type','!=','نقدى')->sum('final_cost');
    }

    public function getDebitsPayedAttribute(){
        #debits_payed
        return $this->debit()->where('debit_paid','!=',0)->sum('debit_value');
    }

    public function getDebitsNotPayedAttribute(){
        #debits_not_payed
        return $this->debit()->where('debit_paid',0)->sum('debit_value');
    }


}
