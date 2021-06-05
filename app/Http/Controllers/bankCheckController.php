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
       $check_count = BankCheck::where('bank_checkable_type','merchant')->count();
       $check_count_late = BankCheck::where(['bank_checkable_type'=>'merchant'])->where('check_date','<',date('Y-m-d'))->count();
       $check_count_wait = BankCheck::where(['bank_checkable_type'=>'merchant'])->where('check_date','>=',date('Y-m-d'))->count();
       $check_count_finished = BankCheck::where(['bank_checkable_type'=>'merchant'])->where('check_date','>',date('Y-m-d'))->count();
      
       return view('admin.bankCheck.clothes')->with(['check_count_finished'=>$check_count_finished,'check_count_wait'=>$check_count_wait,'check_count_late'=>$check_count_late,'check_count'=>$check_count]);
    }

    public function bank_check_orders(){
       $check_count = BankCheck::where('bank_checkable_type','client')->count();
       $check_count_late = BankCheck::where(['bank_checkable_type'=>'client'])->where('check_date','<',date('Y-m-d'))->count();
       $check_count_wait = BankCheck::where(['bank_checkable_type'=>'client'])->where('check_date','>=',date('Y-m-d'))->count();
       $check_count_finished = BankCheck::where(['bank_checkable_type'=>'client'])->where('check_date','>',date('Y-m-d'))->count();
      
       return view('admin.bankCheck.orders')->with(['check_count_finished'=>$check_count_finished,'check_count_wait'=>$check_count_wait,'check_count_late'=>$check_count_late,'check_count'=>$check_count]);
    
    }

    function datatablecheckclothes(){
        $bank_checks = DB::table('bank_checks')->where('bank_checkable_type','merchant')->get();
         return datatables()->of($bank_checks)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;


            })
        ->addColumn('merchant_name', function($row) {
            
               return merchant::where('id',$row->bank_checkable_id)->pluck('merchant_name')[0];
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

          ->addColumn('check_status', function($row) {
                 return '<div class="sparkbar" data-color="#00a65a" data-height="20"><span class="badge badge-'.( ($row->check_date > date('Y-m-d') )?'warning':'danger').'">'.( ($row->check_date > date('Y-m-d') )?'منتظر':'منأخر').'</span></div>';
            })
          ->addColumn('approve', function($row) {
                if($row->payed_check==null){
                  return '<a href='.url('approve-check/'.$row->id).' class="btn btn-success btn-sm"> تسديد </a>';                           
                }
                else
                {
                    return 'تم التسديد';
                }
            })
          ->rawColumns(['select','approve','merchant_name','increase_value','order_number','check_status'])->make(true);

    }


    function datatablecheckorders(){
        $bank_checks = DB::table('bank_checks')->where('bank_checkable_type','client')->get();
         return datatables()->of($bank_checks)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;


            })
        ->addColumn('client_name', function($row) {
              
              if($client_id){
                  return client::where('id',$row->bank_checkable_id)->pluck('client_name')[0];  
              }
              else
              {
                return '-';
              }
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

          ->addColumn('check_status', function($row) {
                 return '<div class="sparkbar" data-color="#00a65a" data-height="20"><span class="badge badge-'.( ($row->check_date > date('Y-m-d') )?'warning':'danger').'">'.( ($row->check_date > date('Y-m-d') )?'منتظر':'منأخر').'</span></div>';
            })
          ->addColumn('approve', function($row) {
                if($row->payed_check==null){
                  return '<a href='.url('approve-check/'.$row->id).' class="btn btn-success btn-sm"> تسديد </a>';                           
                }
                else
                {
                    return 'تم التسديد';
                }
            })
          ->rawColumns(['select','approve','client_name','increase_value','order_number','check_status'])->make(true);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $last_insert = BankCheck::where('id',$id)->update(['payed_check'=>1]);
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
        //
        //$id = $request->Banckcheck_id;
        if($request->Banckcheck_id){
            $status = BankCheck::where('id',$request->Banckcheck_id)->delete();           
            return response()->json(array('status'=>$status));
        }
    }

}
