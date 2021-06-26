<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\suppliers;
use App\SupplierPayment;
class SupplierPayments extends Controller
{
    //

     static function Create($id,$PaymentValue){
        $create_posponed = new SupplierPayment();
        $create_posponed->supplier_id = $id;
        $create_posponed->value       = $PaymentValue ;
        $create_posponed->save();
    }

    static function PaymentValue($id,$value,$type){
         # supplier
        $supplier            = suppliers::find($id);
        # all pauments in order with postponeds
        $SupplierOrderPrices = $supplier->total_cost;
        # all supplier paid in orders
        $SupplierPaid        = $supplier->total_supplier_paid;
        # rest of payments
        $RestPayments        = $SupplierOrderPrices - $SupplierPaid;
        # value of pay
        $PaymentValue        = $value;
        if( $RestPayments < $PaymentValue ):
            $debit_value  = $PaymentValue - $RestPayments;
            if($PaymentValue!=0){
                debitController::insert_debit_data([
                    'debiter_id'     => $id,
                    'section'        => 'suppliers',
                    'value'          => $debit_value,
                    'type_debit'     => 'دائن',
                    'type_payment'   => $type,
                    'order_id'   => null,
                ]);
            }
            $PaymentValue = $RestPayments;
        endif;
        return $PaymentValue;
    }
}
