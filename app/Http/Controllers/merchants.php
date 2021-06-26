<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Redirect,Response,DB,Config;
use App\merchant;
use App\orderClothes;
use App\BankCheck;
use Carbon\Carbon;
use App\MerchantPayment;
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

          # all merchants count
          $merchants_all = merchant::all();
          # all merchant active
          $merchants_active_count      = DB::table('order_clothes')->distinct()->pluck('merchant_id')->count();
          # all merchant have check
          $merchants_have_check_count  =  DB::table('order_clothes')->where('payment_type','شيك')->distinct()->count();
          # last added merchant this month
          $merchants_last_added        = merchant::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString() )->count();
          $Context = [
            'merchants_last_added'=>$merchants_last_added,
            'merchants_have_check'=>$merchants_have_check_count,
            'merchants_active'    =>$merchants_active_count,
            'merchants_count'     =>$merchants_all->count(),
            'merchants_all'       =>$merchants_all
          ];
          return view('admin.merchants.index')->with($Context);

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
                        $select = '<input name="select[]" value="'.$row->id.'" type="checkbox">';
                        return $select;
                    })
                ->addColumn('contact', function($row) {
                        $contact = '<a href="tel:'.$row->merchant_phone.'">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
                                    <a href="tel:'.$row->merchant_phone.'"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>';
                        return $contact;
                    })
                ->addColumn('process', function($row) {
                        $process =  '<div class="btn-group">
                                    <button type="button" class="btn btn-warning">اجراء</button>
                                    <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item delete_single" href="'.url('delete-merchants/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="'.url('merchants/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                                    </div>
                                </div>';
                        return $process;
                    })
                ->addColumn('show', function($row) {
                        $show = '<a href='.url('merchants/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
                        return $show;
                    })
                ->rawColumns(['select','contact','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $Context = [
            'last_merchant' => merchant::latest()->first()
         ];
         return view('admin.merchants.create')->with($Context);
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
             'merchant_name'  => 'required',
             'merchant_phone' => 'required'
        ]);
        $Context = [
            'last_merchant' => merchant::create($request->all()),
            'success'       =>'تم اضافة التاجر بنجاح',
         ];
        return back()->with($Context);
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
        $merchant      = merchant::find($id);
        $order_clothes_info   = $merchant->order_clothes()->where('order_follow',null)->get();
        $Context = [
            'merchant_postponed'=>$merchant->Paid,
            'merchant_bankCheck'=>$merchant->bank_check,
            'merchant_data'     =>$merchant,
            'order_clothes_info'=>$order_clothes_info,
            'total'             =>$merchant->order_clothes->sum('order_price'),
            'total_not_cache'   =>$merchant->order_clothes()->where('payment_type','!=','نقدى')->sum('order_price'),
            'total_cache'       =>$merchant->order_clothes()->where('payment_type','نقدى')->sum('order_price'),
            'paid'              =>$merchant->Paid->sum('value'),
            'debits_payed'      =>$merchant->debits_payed()->sum('debit_value'),
            'debits_not_payed'  =>$merchant->debits()->sum(DB::raw('debit_value - debit_paid')),
        ];
        return view('admin.merchants.single')->with( $Context );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Context = [
            'merchant_data'=> merchant::find($id),
        ];
        return view('admin.merchants.edite')->with($Context);

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

        merchant::where('id',$id)->update($request->only([
            'merchant_name',
            'merchant_phone'
        ]));

        $Context = [
            'success'=>'تم تعديل التاجر بنجاح'
        ];
        return back()->with($Context);

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
        merchant::destroy($id);
        $Context = [
            'success'=>'تم حذف التاجر بنجاح'
        ];
        return back()->with($Context);
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
        merchant::destroy($request->input('select'));
        $Context = [
            'success'=>'تم حذف التاجر بنجاح'
        ];
        return back()->with($Context);
    }

    public function deleteMerchantOrders($id){
        orderClothes::where('merchant_id',$id)->delete();
        $Context = [
            'success'=>'تم حذف طلبات التاجر بنجاح'
        ];
        return back()->with($Context);
    }

    public function truncated(){
        merchant::truncate();
        $Context = [
            'success'=>'تم حذف التاجر بنجاح'
        ];
        return back()->with($Context);
    }

    function addPostponedmerchants(Request $request, $id){
        # add  payments to merchant from
        MerchantPayments::Create($id,MerchantPayments::PaymentValue($id,$request->postponed_value,'دفعات'));
        return back()->with(['success'=>'تم تسديد دفعة بنجاح']);
    }



    function add_check_for_merchant(Request $request , $id){
        # add check in container checkbanck
        bankCheckController::Create([
            'id'            => $id,
            'type'          => 'merchant',
            'check_date'    =>$request->input('check_date'),
            'check_value'   =>$request->input('check_value'),
            'increase_value'=>$request->input('increase_value'),
            'check_owner'   =>$request->input('check_owner')
        ]);
        # add  payments to merchant from Banckcheck
        # MerchantPayments::Create($id,MerchantPayments::PaymentValue($id,$request->input('check_value'),'شيك'));
        return back()->with(['success'=>'تم اضافة شيك بنجاح']);
    }


}
