<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\orderClothes;
use App\ClothStyles;
use App\category;
use App\product;
use App\suppliers;
use App\postponed_suppliers;
use DB;
class ClothStylesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $clothes_count         = ClothStyles::count();
          $ClothStyles_finished  = ClothStyles::where('count_piecies',0)->count();

         return view('admin.ClothStyles.index')->with(['clothes_count'=>$clothes_count,'ClothStyles_finished'=>$ClothStyles_finished,]);
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view('admin.ClothStyles.index-clothes');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreatePiecies($id)
    {
        //
         $get_order_clothes_info = orderClothes::find($id);
         $last_insert            =  ClothStyles::latest()->first();
         $get_all_suppliers      = suppliers::all();
         $Context =[
            'order_clothes_info'=>$get_order_clothes_info->order_not_finished->first(),
            'last_insert'       =>$last_insert,
            'get_all_suppliers' =>$get_all_suppliers
         ];
         return view('admin.ClothStyles.create')->with($Context);
    }

     /**
     * Display a all clothes in datatable
     *
     * @return \Illuminate\Http\Response
     */

    public function datatableClothes(Request $request){
        $orderClothes = orderClothes::whereNull('order_finished')->get();
        return datatables()->of($orderClothes)
                ->addColumn('invoice_no', function($row) {
                        return $row->invoice_no ?? 'بدون ';
                    })
                ->addColumn('merchant_name', function($row) {
                        return $row->merchant->merchant_name;
                    })
                ->addColumn('category_name', function($row) {
                        return $row->category_name->category;
                    })
                ->addColumn('order_price', function($row) {
                        return $row->order_price.' جنية';
                    })
                ->addColumn('Quantity', function($row) {
                        return $row->order_size.' '.$row->order_size_type;
                    })
                ->addColumn('order_discount', function($row) {
                        return ($row->order_discount?$row->order_discount:'0').' جنيه';
                    })
                ->addColumn('show', function($row) {
                    return '<a href='.url('add-piecies/'.$row->id).' class="btn btn-success btn-sm"> اضافة قصات </a>';
                })
                ->rawColumns(['show','invoice_no','merchant_name','category_name','order_price','Quantity'])->make(true);
    }


    public function datatablePiecies(Request $request){
            $clothStyles = ClothStyles::all();
            return datatables()->of($clothStyles)
                    ->addColumn('select', function($row) {
                            return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
                        })
                    ->addColumn('category', function($row) {
                            return $row->orders->category_name->category;
                        })
                    ->addColumn('full_price_handle',function($row){
                        return $row->full_price.' جنيه ';
                    })
                    ->addColumn('count_piecies_handle',function($row){
                        return $row->count_piecies.' قطعة ';
                    })
                    ->addColumn('store_piecies',function($row){
                        return $row->products->count_piecies.' قطعة ';
                    })
                    ->addColumn('created_at',function($row){
                        return $row->created_at;
                    })
                    ->addColumn('process', function($row) {
                            return '<div class="btn-group">
                                        <button type="button" class="btn btn-warning">اجراء</button>
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item delete_single" href="'.url('piecies-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item " href="'.url('piecies/'.$row->id.'/'.$row->order_clothes_id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                                        </div>
                                    </div>';

                        })
                    ->addColumn('show', function($row) {
                            return '<a href='.url('piecies/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
                        })
                    ->rawColumns(['created_at','select','full_price_handle','count_piecies_handle','store_piecies','process','show'])->make(true);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
        $this->validate($request,[
                'order_clothes_id'=>'required',
                'name_piecies'    =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'required',
                'full_price'      =>'required',
        ]);

        #insert clothes
        $last_insert = ClothStyles::create($request->all());

        #create new product that link with clothes
        $insert_product = productsController::CreateProduct(
            $request->only([
                'category_id',
                'name_piecies',
                'price_piecies',
                'count_piecies',
                'additional_taxs',
                'full_price'
            ])
        );

        # add relation between product and Clothes
        $last_insert->products()->save($insert_product);

        # add factory payments
        if(!empty($request->supplier_id) && ($request->factory_money == 1)){
            SupplierPayments::create(
                $request->supplier_id,
                $request->count_piecies * $request->additional_taxs
            );
        }

        # update order that it is finished
        $last_insert->orders()->update(['order_finished'=>true]);
        $Context = [
            'success'        =>'تم اضافة قصات قماش بنجاح',
            'last_ClothSyles'=>$last_insert
        ];
        return redirect('piecies')->with( $Context );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $single_ClothStyles = ClothStyles::find($id);
        $Context = [
            'ClothStyles_info'   =>$single_ClothStyles
        ];
        # return $single_ClothStyles->order_clothes->id;
        return view('admin.ClothStyles.single')->with($Context);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$order_clothes_id)
    {
        //
         $clothes_styles_info    = ClothStyles::find($id);
         $get_all_suppliers      = suppliers::all();
         $Context = [
           'get_all_suppliers' =>$get_all_suppliers,
           'clothes'           =>$clothes_styles_info
         ];
         return view('admin.ClothStyles.edite')->with($Context);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //

        $this->validate($request,[
            'order_clothes_id'=>'required',
            'name_piecies'    =>'required',
            'count_piecies'   =>'required',
            'price_piecies'   =>'required',
            'additional_taxs' =>'',
            'full_price'      =>'required',
        ]);
        $cloth = ClothStyles::find($id);

        $last_insert = $cloth->update($request->only([
            'order_clothes_id',
            'supplier_id',
            'name_piecies',
            'count_piecies',
            'price_piecies',
            'additional_taxs',
            'full_price'
        ]));

        # stop update product when update ClothesStyles
        # $cloth->products()->update([
        #     'name_product'   =>$request->name_piecies,
        #     'price_piecies'  =>$request->price_piecies,
        #     'additional_taxs'=>$request->additional_taxs,
        #     'count_piecies'  =>$request->count_piecies,
        #     'full_price'     =>$request->full_price,
        # ]);

        $Context = [
            'success'        =>'تم تعديل قصات قماش بنجاح',
            'last_ClothSyles'=>$last_insert
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
        $order_clothes = ClothStyles::find($id);
        $order_clothes->orders()->update(['order_finished'=>null]);
        ClothStyles::destroy($id);
        $Context = [
            'success'=>'تم حذف قصات القماش بنجاح'
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

        ClothStyles::whereIn('id',$request->input('select') )->get()->map(function($cloth,$key){
             $cloth->orders()->update(['order_finished'=>null]);
        });

        ClothStyles::destroy($request->input('select') );

        $Context = [
            'success'=>'تم حذف قصات القماش بنجاح'
        ];
        return back()->with($Context);
    }

     /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        $order_clothes_id = ClothStyles::where('id','!=',null)->get()->map(function($cloth,$key){
            $cloth->orders()->update(['order_finished'=>null]);
        });

        ClothStyles::truncate();
        $Context = [
            'success'=>'تم حذف قصات القماش بنجاح'
        ];
        return back()->with($Context);
    }
}
