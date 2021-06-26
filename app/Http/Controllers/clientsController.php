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
          $clients_count  = client::count();
          $active_client  = order::where('client_id','!=',null)->distinct()->count();
          $all_postponeds = order::where('payment_type','دفعات')->distinct()->count();
          $all_check      = order::where('payment_type','شيك')->distinct()->count();
          $Context = [
              'all_check'     =>$all_check,
              'all_postponeds'=>$all_postponeds,
              'active_client' =>$active_client,
              'clients_count'  =>$clients_count,
          ];
          return view('admin.clients.index')->with($Context);
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
            })
            ->addColumn('process', function($row) {
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
            })
            ->addColumn('show', function($row) {
                   return '<a href='.url('clients/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
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
        //
         $last_client_added = client::latest()->first();
         $Context = [
            'last_client'=>$last_client_added
         ];
         return view('admin.clients.create')->with($Context);
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
        $Context = [
            'success'    =>'تم اضافة العميل / الزبون بنجاح',
            'last_client'=>$last_insert
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
        $client_data_info   = client::find($id);
        $Context= [
            'client_id'        =>$id,
            'client_postponed' =>$client_data_info->payments,
            'client_bankCheck' =>$client_data_info->bank_check,
            'order_data_info'  =>$client_data_info->Invoices_orders,
            'client_info'      =>$client_data_info,
            'total_invoices'   =>$client_data_info->total_invoices,
            'total_cache'      =>$client_data_info->total_invoices_cache,
            'total_not_cache'  =>$client_data_info->total_invoices_not_cache,
            'debits_payed'     =>$client_data_info->debits_payed,
            'debits_not_payed' =>$client_data_info->debits_not_payed,
            'rest_debit'       =>$client_data_info->debit()->sum(DB::raw('debit_value - debit_paid')),
            'Paid'             =>$client_data_info->total_payments
        ];
        return view('admin.clients.single')->with($Context);
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
        $client = client::find($id);
        return view('admin.clients.edite')->with('client',$client);

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
        client::destroy($id);
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
        client::destroy($request->input('select'));
        return back()->with(['success'=>'تم حذف العميل / الزبون بنجاح']);
    }

    public function truncated(){
        client::truncate();
        return back()->with(['success'=>'تم حذف العميل / الزبون بنجاح']);
    }


    function addPostponedclients(Request $request, $id){
        # add  payments to merchant from
        ClientPayments::Create($id,ClientPayments::PaymentValue($id,$request->postponed_value,'دفعات'));
        return back()->with(['success'=>'تم تسديد دفعة بنجاح']);
    }


     function add_check_for_client(Request $request , $id){
            # add check in container checkbanck
            bankCheckController::Create([
                'id'            => $id,
                'type'          => 'client',
                'check_date'    =>$request->input('check_date'),
                'check_value'   =>$request->input('check_value'),
                'increase_value'=>$request->input('increase_value'),
                'check_owner'   =>$request->input('check_owner')
            ]);
            # add  payments to merchant from Banckcheck
            # ClientPayments::Create($id,ClientPayments::PaymentValue($id,$request->input('check_value'),'شيك'));
            return back()->with(['success'=>'تم اضافة شيك بنجاح']);
    }
}
