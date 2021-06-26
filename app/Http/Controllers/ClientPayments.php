<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\client;
use App\ClientPayment;
class ClientPayments extends Controller
{
    //
     static function Create($id,$PaymentValue){
        if($PaymentValue == 0) return;
        $create_posponed            = new ClientPayment();
        $create_posponed->client_id = $id;
        $create_posponed->value     = $PaymentValue ;
        $create_posponed->save();
    }

    static function PaymentValue($id,$value,$type){
         # client
        $client              = client::find($id);
        # all pauments in order with postponeds
        $clientOrderPrices   = $client->total_invoices_not_cache;
        # all client paid in orders
        $clientPaid          = $client->total_payments;
        # rest of payments
        $RestPayments        = $clientOrderPrices - $clientPaid;
        # value of pay
        $PaymentValue        = $value;
        if( $RestPayments < $PaymentValue ):
            $debit_value  = $PaymentValue - $RestPayments;
            if($PaymentValue!=0){
                debitController::insert_debit_data([
                    'debiter_id'     => $id,
                    'section'        => 'client',
                    'value'          => $debit_value,
                    'type_debit'     => 'مدين',
                    'type_payment'   => $type,
                    'order_id'   => null,
                ]);
            }
            $PaymentValue = $RestPayments;
        endif;
        return $PaymentValue;
    }
}
