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
use App\suppliers;
use App\ClothStyles;
use App\postponed_suppliers;
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
              // all merchants count
              $suppliers_all     = suppliers::all();
              $suppliers_count   = suppliers::count();


              // last added merchant
              $suppliers_last_added     = suppliers::where('created_at', '>=', Fiscal_Year )->count();
              return view('admin.suppliers.index')->with(['suppliers_last_added'=>$suppliers_last_added,'suppliers_count'=>$suppliers_count,'suppliers_all'=>$suppliers_all]);

        }


        /**
         * Display a all merchants in datatable
         *
         * @return \Illuminate\Http\Response
         */
        public function datatableSuppliers(Request $request){
            $merchants = DB::table('suppliers')->get();
             return datatables()->of($merchants)
            ->addColumn('select', function($row) {
                     return '<input name="select[]" value="'.$row->id.'" type="checkbox">';


                })
            ->addColumn('contact', function($row) {
                     return '<a href="tel:'.$row->supplier_phone.'">  <i class="fab fa-whatsapp-square fa-2x" style="color:#3fad3f" ></i></a>
                             <a href="tel:'.$row->supplier_phone.'"> <i class="fas fa-lg fa-phone fa-2x" style="color:#007bff"></i></a>';

                })
            ->addColumn('count_orders', function($row) {
                     return  ClothStyles::where('supplier_id',$row->id)->count();
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
             $last_suppliers_added = suppliers::orderby('created_at','desc')->first();
             //var_dump($last_merchant_added);
             return view('admin.suppliers.create')->with(['last_suppliers'=>$last_suppliers_added]);
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

            return back()->with(['success'=>'تم اضافة المصنع بنجاح','last_supplier'=>$last_insert]);
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
            $single_merchant = suppliers::where('id',$id)->get();
            $clothes_styles_info   = ClothStyles::where('supplier_id',$id)->get();
            $sum_pospondes_suppliers = postponed_suppliers::where('supplier_id',$id)->sum('posponed_value');
            return view('admin.suppliers.single')->with(['sum_pospondes_suppliers'=>$sum_pospondes_suppliers,'supplier_id'=>$id,'supplier_data'=>$single_merchant,'order_clothes_info'=>$clothes_styles_info]);

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
            suppliers::where('id',$id)->delete();
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
            suppliers::whereIn('id',$request->input('select'))->delete();
            return back()->with(['success'=>'تم حذف المصنع بنجاح']);
        }

        public function deleteMerchantOrders($id){
            orderClothes::where('merchant_id',$id)->delete();
            return back()->with(['success'=>'تم حذف طلبات المصنع بنجاح']);
        }

        public function truncated(){
            suppliers::truncate();
            return back()->with(['success'=>'تم حذف المصنع بنجاح']);
        }

        function addPostponedsuppliers(Request $request, $id){
            if($request->rest_value>=$request->postponed_value):
                $postponed_value = $request->postponed_value;
                $create_posponed = new postponed_suppliers();
                $create_posponed->supplier_id = $id;
                $create_posponed->posponed_value  = $postponed_value;
                $create_posponed->save();
            endif;
               /* $get_all_order   = orderClothes::where(['merchant_id'=>$id,'payment_type'=>'دفعات'])->get();
                foreach ($get_all_order as $key => $order) {
                    $pospondes =   postponed_orderClothes::where('orderClothes_id',$order->id)->sum('posponed_value');
                    if($order->order_price > $pospondes){
                        $rest_value = $order->order_price - ($pospondes?$pospondes:0);
                        if(($rest_value>=$postponed_value) && ($postponed_value > 0) ){
                            $create_posponed = new postponed_orderClothes();
                            $create_posponed->orderClothes_id = $order->id;
                            $create_posponed->posponed_value  = $postponed_value;
                            $create_posponed->save();
                            break;

                        } elseif(($rest_value < $postponed_value) && ($postponed_value > 0) ){
                            $postponed_value =$postponed_value - $rest_value;
                            $create_posponed = new postponed_orderClothes();
                            $create_posponed->orderClothes_id = $order->id;
                            $create_posponed->posponed_value  = $rest_value;
                            $create_posponed->save();
                        }
                    }
                }*/
                return back()->with(['success'=>'تم تسديد دفعة بنجاح']);
            }


}
