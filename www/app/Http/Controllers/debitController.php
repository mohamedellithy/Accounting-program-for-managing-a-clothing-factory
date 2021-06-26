<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\debit;
use App\client;
use App\merchant;
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

          $check_count             =  debit::where('debit_type','دائن')->count();
          $total_debit             =  debit::where('debit_type','دائن')->sum('debit_value');
          $Context = [
              'total_debit'=>$total_debit,
              'check_count'=>$check_count
          ];
          return view('admin.debit.credit')->with( $Context );


    }

    function datatableCredit(Request $request){
         $merchants = debit::Credit()->latest()->get();
         return datatables()->of($merchants)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
            })
        ->addColumn('credit_name', function($row) {
               return $row->debitable->merchant_name ?? $row->debitable->client_name ?? $row->debitable->supplier_name ?? '' ;
            })
         ->addColumn('credit_value', function($row) {
               return $row->debit_value . ' جنيه';
            })
           ->addColumn('rest_value', function($row) {
               return $row->rest_value_of_debit . ' جنيه';
            })
          ->addColumn('section', function($row) {
                return $row->debit_for ?? '';
            })
           ->addColumn('credit_type', function($row) {
               return $row->debit_type;
            })
            ->addColumn('type_payment', function($row) {
               return $row->type_payment;
            })
            ->addColumn('credit_pay', function($row) {
                return ($row->debit_paid < $row->debit_value?
                '<a class="btn btn-success pay_money" style="color:white;font-size: 12px;" debit-cost="'.($row->rest_value_of_debit).'" debit-id="'.$row->id.'" data-toggle="modal" data-target="#modal-default23" >
                <i class="fas fa-pencil-alt"></i>  تسديد مبلغ </a>   ':'تم التسديد');
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

            })
            ->rawColumns(['select','credit_name','rest_value','credit_value','section','credit_type','type_payment','credit_pay','process'])->make(true);

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function debit()
    {
        //

          $check_count       =  debit::where('debit_type','مدين')->count();
          $check_count_late  =  debit::where('debit_type','مدين')->sum('debit_value');
          $check_count_payed =  debit::where('debit_type','مدين')->sum('debit_paid');
          $Context = [
              'check_count_late'=>($check_count_late-$check_count_payed),
              'check_count'     =>$check_count
          ];
          return view('admin.debit.debit')->with( $Context);

    }


    function datatabledebit(Request $request){
        $merchants = debit::Debit()->latest()->get();
            return datatables()->of($merchants)
            ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
            })
            ->addColumn('credit_name', function($row) {
                return $row->debitable->merchant_name ?? $row->debitable->client_name ?? $row->debitable->supplier_name ?? '' ;
            })
            ->addColumn('credit_value', function($row) {
               return $row->debit_value . ' جنيه';
            })
            ->addColumn('rest_value', function($row) {
               return $row->rest_value_of_debit . ' جنيه';
            })
            ->addColumn('section', function($row) {
                return $row->debit_for;
            })
            ->addColumn('credit_type', function($row) {
               return $row->debit_type;
            })
            ->addColumn('type_payment', function($row) {
               return $row->type_payment;
            })
            ->addColumn('credit_pay', function($row) {
               return ($row->debit_paid < $row->debit_value?
                '<a class="btn btn-success pay_money" style="color:white;font-size: 12px;" debit-cost="'.($row->rest_value_of_debit).'" debit-id="'.$row->id.'" data-toggle="modal" data-target="#modal-default23" >
                 <i class="fas fa-pencil-alt"></i>  تسديد مبلغ </a>   ':'تم التسديد');

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

            })
            ->rawColumns(['select','credit_name','rest_value','credit_value','section','credit_type','type_payment','credit_pay','process'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_debit_added = debit::latest()->first();
         $all_merchants    = merchant::all();
         $all_clients      = client::all();
         $all_suppliers    = suppliers::all();
         return view('admin.debit.create')->with(['all_merchants'=>$all_merchants,'all_clients'=>$all_clients,'all_suppliers'=>$all_suppliers,'last'=>$last_debit_added]);
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
        ]);

        if(($request['debitable_type']=='merchant') || ($request['debitable_type']=='suppliers') ):
          $request['debit_type'] = 'دائن';
        else:
          $request['debit_type'] = 'مدين';
        endif;

        $request['type_payment'] = 'دفعات';
        $last_insert = debit::create($request->all());

        return back()->with(['success'=>'تم اضافة المديونية بنجاح','last'=>$last_insert]);

    }

    function Paydebit(Request $request){
        $this->validate($request,[
             'debit_value' => 'required',
             'debit_id'    => 'required',
        ]);
        $debite          = debit::find($request->debit_id);
        $debit_value     = $debite->debit_value - $debite->debit_paid;
        if($debit_value >= $request->debit_value ):
            $Debiter = '';
            if($debite->debitable_type    == 'merchant'):
                $Debiter = 'App\Http\Controllers\MerchantPayments';
            elseif($debite->debitable_type == 'client'):
                $Debiter = 'App\Http\Controllers\ClientPayments';
            elseif($debite->debitable_type =='suppliers'):
                $Debiter = 'App\Http\Controllers\SupplierPayments';
            endif;
            $Debiter::Create($debite->debitable->id,$request->debit_value);
            $create_payed = $debite->increment('debit_paid',$request->debit_value);
            return back()->with(['success'=>'تم تسديد مبلغ بنجاح']);
        endif;
        return back()->with(['error'=>'لم يتم تسديد مبلغ بنجاح']);

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
         $single_debit  = debit::find($id);
         $all_merchants = merchant::all();
         $all_clients   = client::all();
         $all_suppliers = suppliers::all();
         $Context = [
             'debit'        =>$single_debit,
             'all_merchants'=>$all_merchants,
             'all_clients'  =>$all_clients,
             'all_suppliers'=>$all_suppliers
         ];
         return view('admin.debit.edite')->with($Context);

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
        $last_insert = debit::where('id',$id)->update($request->only(['debit_value','debit_paid']));
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
        debit::destory($id);
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
        debit::destory($request->input('select'));
        return back()->with(['success'=>'تم حذف المديونية بنجاح']);
    }


    public function truncated($debit_type){
        debit::where('debit_type',$debit_type)->delete();
        return back()->with(['success'=>'تم حذف المديونية بنجاح']);
    }

    public static function insert_debit_data(Array $data = []){
        if($data['value']!=null):
            $section       =  ($data['section']=='suppliers'?'suppliers':$data['section']);
            $debit_name    =  new debit();
            $debit_name->debitable_id  = $data['debiter_id'];
            $debit_name->debitable_type= $section;
            $debit_name->debit_value   = $data['value'];
            $debit_name->debit_type    = $data['type_debit'];
            $debit_name->type_payment  = $data['type_payment'];
            $debit_name->debit_paid    = 0;
            $debit_name->order_id      = $data['order_id'];
            $debit_name->save();
            return $debit_name;
        endif;
    }

}
