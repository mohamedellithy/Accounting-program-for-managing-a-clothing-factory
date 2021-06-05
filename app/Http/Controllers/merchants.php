<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Redirect,Response,DB,Config;
use App\merchant;
use App\orderClothes;
use App\BankCheck;
use Carbon\Carbon;
use App\postponed_orderClothes;
class merchants extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          // all merchants count
          $merchants_all     = merchant::all();
          $merchants_count   = merchant::count();

          // all merchant active
          $merchants_active      = DB::table('order_clothes')->distinct()->pluck('merchant_id')->toArray();
          $merchants_active_count = count($merchants_active);
          
          // all merchant have check
          $merchants_have_check  =  DB::table('order_clothes')->where('payment_type','شيك')->distinct()->pluck('merchant_id')->toArray(); //orderClothes::whereIn('merchant_id',$merchants_ids)->andWhere('payment_type','شيك')->count();
          $merchants_have_check_count = count($merchants_have_check);
          
          // last added merchant   
          $merchants_last_added     = merchant::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString() )->count();
          return view('admin.merchants.index')->with(['merchants_last_added'=>$merchants_last_added,'merchants_have_check'=>$merchants_have_check_count,'merchants_active'=>$merchants_active_count,'merchants_count'=>$merchants_count,'merchants_all'=>$merchants_all]);
         
    }
    

    /**
     * Display a all merchants in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableMerchants(Request $request){
        $merchants = DB::table('merchants')->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';


            })
        ->addColumn('contact', function($row) {
                 return '<a href="tel:'.$row->merchant_phone.'">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
                         <a href="tel:'.$row->merchant_phone.'"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>';

            })->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('merchant-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('merchant-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-merchant/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','contact','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_merchant_added = merchant::orderby('created_at','desc')->first();
         //var_dump($last_merchant_added);
         return view('admin.merchants.create')->with(['last_merchant'=>$last_merchant_added]);
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
             'merchant_name' => 'required',
             'merchant_phone' => 'required'
        ]);
        $last_insert = merchant::create($request->all());
        return back()->with(['success'=>'تم اضافة التاجر بنجاح','last_merchant'=>$last_insert]);
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
        $single_merchant = merchant::where('id',$id)->get();
        $order_clothes_info   = orderClothes::where('merchant_id',$id)->where('order_follow',null)->get();
        $merchant_bankCheck   = BankCheck::where(['bank_checkable_id'=>$id])->get();
        $merchant_postponed   = postponed_orderClothes::where(['merchant_id'=>$id])->get();
        return view('admin.merchants.single')->with(['merchant_postponed'=>$merchant_postponed,'merchant_bankCheck'=>$merchant_bankCheck,'merchant_id'=>$id,'merchant_data'=>$single_merchant,'order_clothes_info'=>$order_clothes_info]);

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
        $merchant_data_info = merchant::where('id',$id)->get();
        return view('admin.merchants.edite')->with('merchant_data',$merchant_data_info);

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
             'merchant_name' => 'required',
             'merchant_phone' => 'required'
        ]);
        $last_insert = merchant::where('id',$id)->update($request->only(['merchant_name','merchant_phone']));
        return back()->with(['success'=>'تم تعديل التاجر بنجاح']);
   
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
        merchant::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف التاجر بنجاح']);
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
        merchant::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف التاجر بنجاح']);
    }

    public function deleteMerchantOrders($id){
        orderClothes::where('merchant_id',$id)->delete();
        return back()->with(['success'=>'تم حذف طلبات التاجر بنجاح']);
    }

    public function truncated(){
        merchant::truncate();
        return back()->with(['success'=>'تم حذف التاجر بنجاح']);
    }

    function addPostponedmerchants(Request $request, $id){
            $postponed_value = $request->postponed_value;
            if( ($request->order_price > $postponed_value ) && ($postponed_value > 0) ){
                $create_posponed = new postponed_orderClothes();
                $create_posponed->merchant_id = $id;
                $create_posponed->posponed_value  = $postponed_value;
                $create_posponed->save();
            }
            else
            {
                $rest_value =$postponed_value-$request->order_price; 
                $create_posponed = new postponed_orderClothes();
                $create_posponed->merchant_id = $id;
                $create_posponed->posponed_value  = $request->order_price;
                $create_posponed->save();

                if($postponed_value!=0){
                    insert_debit_data($id,'merchant','دائن',$rest_value,'دفعات',null);
                }
            }
        return back()->with(['success'=>'تم تسديد دفعة بنجاح']);

    }



    function add_check_for_merchant(Request $request , $merchant_id){
            if( ($request->order_price >  $request->input('check_value') ) && ( $request->input('check_value') > 0) ){
                $insert_bankcheck = new BankCheck();
                $insert_bankcheck->bank_checkable_id = $merchant_id;
                $insert_bankcheck->bank_checkable_type = 'merchant';
                $insert_bankcheck->check_date  = $request->input('check_date');
                $insert_bankcheck->check_value = $request->input('check_value');
                $insert_bankcheck->increase_value = $request->input('increase_value');
                $insert_bankcheck->check_owner = $request->input('check_owner');
                $insert_bankcheck->save();
            }
            else
            {
                $rest_value = $request->input('check_value')-$request->order_price; 
                $insert_bankcheck = new BankCheck();
                $insert_bankcheck->bank_checkable_id = $merchant_id;
                $insert_bankcheck->bank_checkable_type = 'merchant';
                $insert_bankcheck->check_date  = $request->input('check_date');
                $insert_bankcheck->check_value = $request->input('check_value');
                $insert_bankcheck->increase_value = $request->input('increase_value');
                $insert_bankcheck->check_owner = $request->input('check_owner');
                $insert_bankcheck->save();

                if($rest_value!=0){
                    insert_debit_data($merchant_id,'merchant','دائن',$rest_value,'شيك',null);
                }
            }
                return back()->with(['success'=>'تم اضافة شيك بنجاح']);
    }
}
