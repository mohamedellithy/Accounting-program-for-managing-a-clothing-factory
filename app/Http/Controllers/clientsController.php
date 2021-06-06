<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\merchant;
use DB;
use App\order;
use App\BankCheck;
use App\client;
use App\postponed;
class clientsController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $merchants_all  = client::all();
          $client_count   = client::count();
          $active_client  = order::where('client_id','!=',null)->distinct()->pluck('client_id')->toArray();
          $all_postponeds  = order::where('payment_type','دفعات')->distinct()->pluck('client_id')->toArray();
          $all_check  = order::where('payment_type','شيك')->distinct()->pluck('client_id')->toArray();
         /* $orderClothes_check  = orderClothes::where('payment_type','شيك')->count();
          $orderClothes_postponed  = orderClothes::where('payment_type','دفعات')->count();
         */ return view('admin.clients.index')->with(['all_check'=>($all_check?count($all_check):0),'all_postponeds'=>$all_postponeds,'active_client'=>($active_client?count($active_client):'0'),'client_count'=>$client_count,'merchants_all'=>$merchants_all]);

    }


    /**
     * Display a all merchants in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableClients(Request $request){
        $merchants = DB::table('clients')->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';


            })
        ->addColumn('contact', function($row) {
                 return '<a href="tel:'.$row->client_phone.'">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
                         <a href="tel:'.$row->client_phone.'"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>';

            })->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('client-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('clients/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('clients/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
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
         $last_client_added = client::orderby('created_at','desc')->first();
         //var_dump($last_client_added);
         return view('admin.clients.create')->with(['last_client'=>$last_client_added]);
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
             'client_name' => 'required',
             'client_phone' => 'required'
        ]);
        $last_insert = client::create($request->all());
        return back()->with(['success'=>'تم اضافة العميل / الزبون بنجاح','last_client'=>$last_insert]);
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
        $client_data_info = client::where('id',$id)->get();
        $order_data_info  = order::where('client_id',$id)->where('order_follow',null)->get();
        $client_bankCheck   = BankCheck::where(['bank_checkable_id'=>$id])->get();
        $client_postponed   = postponed::where(['client_id'=>$id])->get();
        return view('admin.clients.single')->with(['client_id'=>$id,'client_postponed'=>$client_postponed,'client_bankCheck'=>$client_bankCheck,'order_data_info'=>$order_data_info,'client_data'=>$client_data_info]);
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
        $client_data_info = client::where('id',$id)->get();
        return view('admin.clients.edite')->with('client_data',$client_data_info);

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
             'client_name' => 'required',
             'client_phone' => 'required'
        ]);
        $last_insert = client::where('id',$id)->update($request->only(['client_name','client_phone']));
        return back()->with(['success'=>'تم تعديل العميل / الزبون بنجاح']);

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
        client::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف العميل / الزبون بنجاح']);
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
        client::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف العميل / الزبون بنجاح']);
    }

    public function truncated(){
        client::truncate();
        return back()->with(['success'=>'تم حذف العميل / الزبون بنجاح']);
    }


    function addPostponedclients(Request $request, $id){
        $postponed_value = $request->postponed_value;
        $pospondes =   postponed::where('client_id',$id)->sum('posponed_value');
            if( ($request->final_cost >= $postponed_value) && ($postponed_value > 0) ){
                $create_posponed = new postponed();
                $create_posponed->client_id = $id;
                $create_posponed->posponed_value  = $postponed_value;
                $create_posponed->save();
            }
            else
            {
                $rest_value =$postponed_value-$request->final_cost;
                $create_posponed = new postponed();
                $create_posponed->client_id = $id;
                $create_posponed->posponed_value  = $request->final_cost;
                $create_posponed->save();

                 if($postponed_value!=0){
                    insert_debit_data($id,'client','مدين',$rest_value,'دفعات',null);
                 }
            }

        return back()->with(['success'=>'تم تسديد دفعة بنجاح']);

    }


     function add_check_for_client(Request $request , $client_id){
            if( ($request->order_price >  $request->input('check_value') ) && ( $request->input('check_value') > 0) ){
                $insert_bankcheck = new BankCheck();
                $insert_bankcheck->bank_checkable_id = $client_id;
                $insert_bankcheck->bank_checkable_type = 'client';
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
                $insert_bankcheck->bank_checkable_id = $client_id;
                $insert_bankcheck->bank_checkable_type = 'client';
                $insert_bankcheck->check_date  = $request->input('check_date');
                $insert_bankcheck->check_value = $request->input('check_value');
                $insert_bankcheck->increase_value = $request->input('increase_value');
                $insert_bankcheck->check_owner = $request->input('check_owner');
                $insert_bankcheck->save();

                if($rest_value!=0){
                    insert_debit_data($client_id,'client','مدين',$rest_value,'شيك',null);
                }
            }
                return back()->with(['success'=>'تم اضافة شيك بنجاح']);
    }
}
