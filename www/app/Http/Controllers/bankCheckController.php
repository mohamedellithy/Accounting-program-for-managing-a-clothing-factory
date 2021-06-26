<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankCheck;
use App\orderClothes;
use App\merchant;
use App\order;
use App\client;
use DB;
class bankCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function bank_check_clothes(){
       $check_count          = BankCheck::merchantcheque()->count();
       $check_count_late     = BankCheck::merchantcheque()->where('check_date','<',date('Y-m-d'))->count();
       $check_count_wait     = BankCheck::merchantcheque()->where('check_date','>=',date('Y-m-d'))->count();
       $check_count_finished = BankCheck::merchantcheque()->where('check_date','>',date('Y-m-d'))->count();

       return view('admin.bankCheck.clothes')->with(['check_count_finished'=>$check_count_finished,'check_count_wait'=>$check_count_wait,'check_count_late'=>$check_count_late,'check_count'=>$check_count]);
    }

    public function bank_check_orders(){
       $check_count      = BankCheck::clientcheque()->count();
       $check_count_late = BankCheck::clientcheque()->where('check_date','<',date('Y-m-d'))->count();
       $check_count_wait = BankCheck::clientcheque()->where('check_date','>=',date('Y-m-d'))->count();
       $check_count_finished = BankCheck::clientcheque()->where('check_date','>',date('Y-m-d'))->count();

       return view('admin.bankCheck.orders')->with(['check_count_finished'=>$check_count_finished,'check_count_wait'=>$check_count_wait,'check_count_late'=>$check_count_late,'check_count'=>$check_count]);

    }

    function datatablecheckclothes(){
        $bank_checks = BankCheck::merchantcheque()->get();
        return datatables()->of($bank_checks)
            ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
            })
            ->addColumn('merchant_name', function($row) {
               return $row->bank_checkable->merchant_name ?? '';
            })
            ->addColumn('order_number', function($row) {
                 return '#'.$row->bank_checkable_id;
            })
            ->addColumn('check_value', function($row) {
                 return $row->check_value.' جنيه ';
            })
            ->addColumn('increase_value', function($row) {
                 return ($row->increase_value?$row->increase_value:'0').' جنيه ';
            })
            ->addColumn('approve', function($row) {
                if($row->payed_check==null){
                  return '<a href='.url('approve-cheque/'.$row->id).' class="btn btn-success btn-sm"> تسديد </a>';
                }
                return 'تم التسديد';
            })
            ->rawColumns(['select','approve','merchant_name','increase_value','order_number'])->make(true);

    }


    function datatablecheckorders(){
        $bank_checks = BankCheck::clientcheque()->get();
         return datatables()->of($bank_checks)
            ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
            })
            ->addColumn('client_name', function($row) {
                 return $row->bank_checkable->client_name ?? '';
            })
            ->addColumn('order_number', function($row) {
                 return '#'.$row->bank_checkable_id;
            })
            ->addColumn('check_value', function($row) {
                 return $row->check_value.' جنيه ';
            })
            ->addColumn('increase_value', function($row) {
                 return ($row->increase_value?$row->increase_value:'0').' جنيه ';
            })
            ->addColumn('approve', function($row) {
                if($row->payed_check==null){
                  return '<a href='.url('approve-cheque/'.$row->id).' class="btn btn-success btn-sm"> تسديد </a>';
                }
                return 'تم التسديد';
            })
            ->rawColumns(['select','approve','client_name','increase_value','order_number'])->make(true);

    }

    static function Create($CheckData){
        $insert_bankcheck = new BankCheck();
        $insert_bankcheck->bank_checkable_id   = $CheckData['id'];
        $insert_bankcheck->bank_checkable_type = $CheckData['type'];
        $insert_bankcheck->check_date          = $CheckData['check_date'];
        $insert_bankcheck->check_value         = $CheckData['check_value'];
        $insert_bankcheck->increase_value      = $CheckData['increase_value'];
        $insert_bankcheck->check_owner         = $CheckData['check_owner'];
        $insert_bankcheck->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $cheque = BankCheck::find($id);
        $cheque->update(['payed_check'=>1]);
        if($cheque->bank_checkable_type=='merchant'):
            # add  payments to merchant from Banckcheck
            MerchantPayments::Create($cheque->bank_checkable->id,MerchantPayments::PaymentValue($cheque->bank_checkable->id,$cheque->check_value,'شيك'));
        elseif($cheque->bank_checkable_type=='client'):
            # add  payments to merchant from Banckcheck
            ClientPayments::Create($cheque->bank_checkable->id,ClientPayments::PaymentValue($cheque->bank_checkable->id,$cheque->check_value,'شيك'));
        endif;
        return back()->with(['success'=>'تم تم تسديد الشيك بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id=null)
    {
        if($request->Banckcheck_id){
            $status = BankCheck::destroy($request->Banckcheck_id);
            return response()->json(array('status'=>$status));
        }
    }


}
