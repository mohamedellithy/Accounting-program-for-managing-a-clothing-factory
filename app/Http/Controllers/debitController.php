<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\debit;
use App\client;
use App\merchant;

use App\postponed_orderClothes;
use App\postponed;
use App\suppliers;
use DB;
class debitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function credit()
    {
        //

        /*  $clothes_count   = ClothStyles::count();
          $ClothStyles_finished  = ClothStyles::where('count_piecies',0)->count();
         */
        /*  $check_count      =  debit::where('debit_type','دائن')->count();
          $check_count_late =  debit::where('debit_type','دائن')->sum('debit_value');
          return view('admin.debit.credit')->with(['check_count_late'=>$check_count_late,'check_count'=>$check_count]);*/
          $check_count             =  debit::where('debit_type','دائن')->count();
          $check_count_payed       =  debit::where('debit_type','دائن')->where('type_payment','!=','متأخرات')->sum('payed_check');
          $check_count_late        =  debit::where('debit_type','دائن')->where('type_payment','!=','متأخرات')->sum('debit_value');    
          $get_all_debit_later_special     =  debit::where('type_payment','متأخرات')->sum('debit_value');
          $get_all_sales_postponed = postponed::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
          $get_payed_from_posponed = ( (($get_all_debit_later_special-$get_all_sales_postponed)>0)?($get_all_debit_later_special-$get_all_sales_postponed):0);
          return view('admin.debit.credit')->with(['check_count_late'=>(($check_count_late - $check_count_payed)+$get_payed_from_posponed ),'check_count'=>$check_count]);
   
   
    }

    function datatableCredit(Request $request){
         $merchants = DB::table('debits')->where('debit_type','دائن')->orderby('created_at','ASC')->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';


            })
        ->addColumn('credit_name', function($row) {
                if($row->debitable_type!=null):
                    return get_debit_name($row->debitable_type,$row->debitable_id); 
                else:
                    return $row->debit_name;
                endif; 
            })
         ->addColumn('credit_value', function($row) {
               return $row->debit_value . ' جنيه';
            })
           ->addColumn('rest_value', function($row) {
               return $row->debit_value-$row->payed_check . ' جنيه';
            })
          ->addColumn('section', function($row) {
                return get_debit_section($row->debitable_type);
            })
           ->addColumn('credit_type', function($row) {
               return $row->debit_type;
            })
            ->addColumn('type_payment', function($row) {
               return $row->type_payment;
            })
            ->addColumn('credit_pay', function($row) {
                if($row->type_payment!='متأخرات'):
                     return ($row->payed_check<$row->debit_value?'<a class="btn btn-success pay_money" style="color:white;font-size: 12px;" debit-cost="'.($row->debit_value-$row->payed_check).'" debit-id="'.$row->id.'" data-toggle="modal" data-target="#modal-default23" > <i class="fas fa-pencil-alt"></i>  تسديد مبلغ </a>   ':'تم التسديد');
                else:
                    return '----';
                endif;
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('debit-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('debit-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->rawColumns(['select','credit_name','rest_value','credit_value','section','credit_type','type_payment','credit_pay','process'])->make(true);

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function debit()
    {
        //

        /*  $clothes_count   = ClothStyles::count();
          $ClothStyles_finished  = ClothStyles::where('count_piecies',0)->count();
         */
          $check_count       =  debit::where('debit_type','مدين')->count();
          $check_count_late  =  debit::where('debit_type','مدين')->sum('debit_value');
          $check_count_payed =  debit::where('debit_type','مدين')->sum('payed_check');
          return view('admin.debit.debit')->with(['check_count_late'=>($check_count_late-$check_count_payed),'check_count'=>$check_count]);
   
    }


    function datatabledebit(Request $request){
         $merchants = DB::table('debits')->where('debit_type','مدين')->orderby('created_at','ASC')->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';


            })
        ->addColumn('credit_name', function($row) {
                if($row->debitable_type!=null):
                    return get_debit_name($row->debitable_type,$row->debitable_id); 
                else:
                    return $row->debit_name;
                endif; 
            })
         ->addColumn('credit_value', function($row) {
               return $row->debit_value . ' جنيه';
            })
           ->addColumn('rest_value', function($row) {
               return $row->debit_value-$row->payed_check . ' جنيه';
            })
          ->addColumn('section', function($row) {
                return get_debit_section($row->debitable_type);
            })
           ->addColumn('credit_type', function($row) {
               return $row->debit_type;
            })
            ->addColumn('type_payment', function($row) {
               return $row->type_payment;
            })
            ->addColumn('credit_pay', function($row) {
              if($row->type_payment!='متأخرات'):
                  return ($row->payed_check<$row->debit_value?'<a class="btn btn-success pay_money" style="color:white;font-size: 12px;" debit-cost="'.($row->debit_value-$row->payed_check).'" debit-id="'.$row->id.'" data-toggle="modal" data-target="#modal-default23" > <i class="fas fa-pencil-alt"></i>  تسديد مبلغ </a>   ':'تم التسديد');
              endif;
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('debit-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('debit-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->rawColumns(['select','credit_name','rest_value','credit_value','section','credit_type','type_payment','credit_pay','process'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_debit_added = debit::orderby('created_at','desc')->first();
         $all_merchants =merchant::all();
         $all_clients   =client::all();
         $all_suppliers =suppliers::all();
         return view('admin.debit.create')->with(['all_merchants'=>$all_merchants,'all_clients'=>$all_clients,'all_suppliers'=>$all_suppliers,'last_debit'=>$last_debit_added]);
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
        $this->validate($request,[
             'debit_value' => 'required',
             'debit_type' => 'required',
             'type_payment'=>'required',
        ]);
       
        $request['payed_check']=0;
       
        if(($request['debitable_type']=='client') && ($request['debit_type']=='دائن') ):
          $request['type_payment'] = 'متأخرات';    
        endif;
        $last_insert = debit::create($request->all());

        return back()->with(['success'=>'تم اضافة المديونية بنجاح','last_merchant'=>$last_insert]);
        
    }

    function Paydebit(Request $request){
         $this->validate($request,[
             'debit_value' => 'required',
             'debit_id' => 'required',
        ]);
         $debiter_id = debit::where('id',$request->debit_id)->pluck('debitable_id')[0];
         $debitable_type = debit::where('id',$request->debit_id)->pluck('debitable_type')[0];
         if($request['type_paydebit']==1):
             if($debitable_type=='merchant'):
                $create_posponed = new postponed_orderClothes();
                $create_posponed->posponed_value = $request->debit_value;
                $create_posponed->merchant_id      = $debiter_id;                 
                $create_posponed->save();
             elseif($debitable_type=='client'):
                $create_posponed = new postponed();
                $create_posponed->posponed_value = $request->debit_value;
                $create_posponed->client_id      = $debiter_id;                 
                $create_posponed->save();
             elseif($debitable_type=='suppliers'):
                $create_posponed = new suppliers();
                $create_posponed->posponed_value = $request->debit_value;
                $create_posponed->supplier_id      = $debiter_id;                 
                $create_posponed->save();
             endif;
         endif;  
         $create_payed =debit::where('id',$request->debit_id)->increment('payed_check',$request->debit_value);
         return back()->with(['success'=>'تم تسديد مبلغ بنجاح']);

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
         $single_debit = debit::where('id',$id)->get();
         $all_merchants =merchant::all();
         $all_clients   =client::all();
         $all_suppliers =suppliers::all();
         return view('admin.debit.edite')->with(['single_debit'=>$single_debit,'all_merchants'=>$all_merchants,'all_clients'=>$all_clients,'all_suppliers'=>$all_suppliers]);
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
             'debit_value' => 'required',
        ]);
        $last_insert = debit::where('id',$id)->update($request->only(['debitable_id','debitable_type','debit_value','debit_type','payed_check','type_payment','debit_name']));
        return back()->with(['success'=>'تم تعديل المديونية بنجاح']);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        debit::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف المديونية بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request){
        if(!$request->input('select')){
          return back();
        }
        debit::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف المديونية بنجاح']);
    }


    public function truncated($debit_type){
        debit::where('debit_type',$debit_type)->delete();
        return back()->with(['success'=>'تم حذف المديونية بنجاح']);
    }

}
