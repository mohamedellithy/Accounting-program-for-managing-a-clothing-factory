<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MerchantPayment;
use App\merchant;
class MerchantPayments extends Controller
{
    //

    static function Create($id,$PaymentValue){
        $create_posponed = new MerchantPayment();
        $create_posponed->merchant_id = $id;
        $create_posponed->value       = $PaymentValue ;
        $create_posponed->save();
    }

    static function PaymentValue($id,$value,$type){
         # merchant
        $merchant            = merchant::find($id);
        # all pauments in order with postponeds
        $MerchantOrderPrices = $merchant->Cloth_Orders->where('payment_type','!=','نقدى')->sum('order_price');
        # all mercahant paid in orders
        $MerchantPaid        = $merchant->Paid->sum('value');
        # rest of payments
        $RestPayments        = $MerchantOrderPrices - $MerchantPaid;
        # value of pay
        $PaymentValue        = $value;
        if( $RestPayments < $PaymentValue ):
            $debit_value  = $PaymentValue - $RestPayments;
            if($PaymentValue!=0){
                debitController::insert_debit_data([
                    'debiter_id'     => $id,
                    'section'        => 'merchant',
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
