<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Redirect,Response,DB,Config;
use App\merchant;
use App\orderClothes;
use App\BankCheck;
use Carbon\Carbon;
use App\suppliers;
use App\ClothStyles;
class suppliersController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //
              $suppliers_count = suppliers::count();
              $last_added      = suppliers::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString() )->count();
              return view('admin.suppliers.index')->with(['suppliers_last_added'=>$last_added,'suppliers_count'=>$suppliers_count]);

        }


        /**
         * Display a all merchants in datatable
         *
         * @return \Illuminate\Http\Response
         */
        public function datatableSuppliers(Request $request){
            $suppliers = suppliers::all();
             return datatables()->of($suppliers)
            ->addColumn('select', function($row) {
                     return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
                })
            ->addColumn('contact', function($row) {
                     return '<a href="tel:'.$row->supplier_phone.'">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
                             <a href="tel:'.$row->supplier_phone.'"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>';

                })
            ->addColumn('count_orders', function($row) {
                     return  $row->clothes_styles->count();
                })
            ->addColumn('process', function($row) {
                     return '<div class="btn-group">
                                <button type="button" class="btn btn-warning">اجراء</button>
                                <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item delete_single" href="'.url('supplier-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item " href="'.url('suppliers/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                                </div>
                            </div>';

                })->addColumn('show', function($row) {
                       return '<a href='.url('suppliers/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
                })->rawColumns(['select','count_orders','contact','process','show'])->make(true);

        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            //
             $last_suppliers_added = suppliers::latest()->first();
             $Context = [
                 'last_suppliers'=> $last_suppliers_added
             ];
             return view('admin.suppliers.create')->with($Context);
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
                 'supplier_name' => 'required',
                 'supplier_phone' => 'required'
            ]);

            $last_insert = suppliers::create($request->all());
            $Context = [
               'success'       =>'تم اضافة المصنع بنجاح',
               'last_supplier' =>$last_insert
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
            $supplier  = suppliers::find($id);
            $Context   = [
                'supplier'  =>$supplier,
            ];
            return view('admin.suppliers.single')->with($Context);

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
            $supplier_data_info = suppliers::where('id',$id)->get();
            return view('admin.suppliers.edite')->with('supplier_data',$supplier_data_info);

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
                 'supplier_name' => 'required',
                 'supplier_phone' => 'required'
            ]);
            $last_insert = suppliers::where('id',$id)->update($request->only(['supplier_name','supplier_phone']));
            return back()->with(['success'=>'تم تعديل المصنع بنجاح']);

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
            suppliers::destroy($id);
            return back()->with(['success'=>'تم حذف المصنع بنجاح']);
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
            suppliers::destroy($request->input('select'));
            return back()->with(['success'=>'تم حذف المصنع بنجاح']);
        }


        public function truncated(){
            suppliers::truncate();
            return back()->with(['success'=>'تم حذف المصنع بنجاح']);
        }

        function addPostponedsuppliers(Request $request, $id){
            # add  payments to merchant from
            SupplierPayments::Create($id,SupplierPayments::PaymentValue($id,$request->postponed_value,'دفعات'));
            return back()->with(['success'=>'تم تسديد دفعة بنجاح']);
        }


}
