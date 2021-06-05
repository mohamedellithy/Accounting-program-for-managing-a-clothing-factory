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
          $clothes_count   = ClothStyles::count();
          $ClothStyles_finished  = ClothStyles::where('count_piecies',0)->count();
         
         return view('admin.ClothStyles.index')->with(['clothes_count'=>$clothes_count,'ClothStyles_finished'=>$ClothStyles_finished,]);
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexClothes()
    {
        //
         return view('admin.ClothStyles.index-clothes');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
         $get_order_clothes_info = orderClothes::where(['id'=>$id,'order_finished'=>null])->get();
         $last_insert =  ClothStyles::orderby('created_at','desc')->first();
         $get_all_suppliers = suppliers::all();
         return view('admin.ClothStyles.create')->with(['order_clothes_info'=>$get_order_clothes_info,'last_ClothSyles'=>$last_insert,'get_all_suppliers'=>$get_all_suppliers]);
    }

     /**
     * Display a all clothes in datatable
     *
     * @return \Illuminate\Http\Response
     */

    public function datatableClothes(Request $request){
        $orderClothes = DB::table('order_clothes')->where('order_finished',null)->get();
         return datatables()->of($orderClothes)
        ->addColumn('merchant_name', function($row) {
                 return DB::table('merchants')->where('id',$row->merchant_id)->pluck('merchant_name')[0];
            })
        ->addColumn('category_name', function($row) {
                 return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
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
            })->rawColumns(['show','merchant_name','category_name','order_price','Quantity'])->make(true);
    }


    public function datatablePiecies(Request $request){
          $clothStyles = DB::table('cloth_styles')->leftJoin('order_clothes','cloth_styles.order_clothes_id','=','order_clothes.id')->select('cloth_styles.id as id','cloth_styles.created_at','cloth_styles.order_clothes_id','cloth_styles.full_price','cloth_styles.count_piecies','order_clothes.category_id','cloth_styles.name_piecies')->get();
         return datatables()->of($clothStyles)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;

            })
         ->addColumn('category', function($row) {
                if(!empty($row->category_id)){
                     return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
                } 
                 return ' - ';
            })

         ->addColumn('full_price_handle',function($row){
               return $row->full_price.' جنيه '; 
         })
         ->addColumn('count_piecies_handle',function($row){
               return $row->count_piecies.' قطعة '; 
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
                              <a class="dropdown-item " href="'.url('piecies-edite/'.$row->id.'/'.$row->order_clothes_id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-piecies/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','full_price_handle','count_piecies_handle','process','show'])->make(true);

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
                'order_clothes_id'=>'required', 
                'name_piecies'    =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'required',
                'full_price'      =>'required',
        ]);
        $last_insert = ClothStyles::create($request->all());
        $insert_product = new product();
        $insert_product->cloth_styles_id = $last_insert->id; 
        $insert_product->category_id     = $request->category_id;
        $insert_product->name_product    = $request->name_piecies;
        $insert_product->price_piecies   = $request->price_piecies;
        $insert_product->count_piecies   = $request->count_piecies;
        $insert_product->additional_taxs = $request->additional_taxs; 
        $insert_product->full_price      = $request->full_price; 
        $insert_product->save();

         if($request->factory_money==1){
                $create_posponed = new postponed_suppliers();
                $create_posponed->supplier_id = $request->supplier_id;
                $create_posponed->posponed_value  = $request->count_piecies * $request->additional_taxs ;
                $create_posponed->save();
            }

        orderClothes::where(['id'=>$request->input('order_clothes_id'),'order_finished'=>null])->update(['order_finished'=>true]);
        return redirect('show-piecies')->with(['success'=>'تم اضافة قصات قماش بنجاح','last_ClothSyles'=>$last_insert]);
   
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
        //$client_data_info = ClothStyles::where('id',$id)->get();
        $single_ClothStyles = ClothStyles::where('id',$id)->get();
        $order_clothes_id = ClothStyles::where('id',$id)->pluck('order_clothes_id')[0];
        $order_clothes_style  = orderClothes::where('id',$order_clothes_id)->get();
     
        return view('admin.ClothStyles.single')->with(['cloth_style_id'=>$id,'order_clothes_style'=>$order_clothes_style,'ClothStyles_info'=>$single_ClothStyles]);
    
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
         $clothes_styles_info    = ClothStyles::where('id',$id)->get();
         $get_order_clothes_info = orderClothes::where(['id'=>$order_clothes_id])->get();
         $get_all_suppliers = suppliers::all();
         return view('admin.ClothStyles.edite')->with(['get_all_suppliers'=>$get_all_suppliers,'order_clothes_info'=>$get_order_clothes_info,'clothes_styles'=>$clothes_styles_info]);
    
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
                'order_clothes_id'=>'required', 
                'name_piecies'    =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'',
                'full_price'      =>'required',
        ]);
        $last_insert = ClothStyles::where('id',$id)->update($request->only(['order_clothes_id','supplier_id','name_piecies','count_piecies','price_piecies','additional_taxs','full_price']) );
        product::where('cloth_styles_id',$id)->update(['name_product'=>$request->name_piecies,
        'price_piecies'=>$request->price_piecies,'additional_taxs'=>$request->additional_taxs,'count_piecies'=>$request->count_piecies,'full_price'=>$request->full_price]);
       
        return back()->with(['success'=>'تم تعديل قصات قماش بنجاح','last_ClothSyles'=>$last_insert]);
   
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
        $order_clothes_id = ClothStyles::where('id',$id)->pluck('order_clothes_id')[0]; 
        orderClothes::where(['id'=>$order_clothes_id,'order_finished'=>true])->update(['order_finished'=>null]);
        ClothStyles::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف قصات القماش بنجاح']);
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
        $order_clothes_id = ClothStyles::whereIn('id',$request->input('select') )->pluck('order_clothes_id')->toArray(); 
        orderClothes::whereIn('id',$order_clothes_id)->update(['order_finished'=>null]);
        
        ClothStyles::whereIn('id', $request->input('select') )->delete();
        return back()->with(['success'=>'تم حذف قصات القماش بنجاح']);
    }

     /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        $order_clothes_id = ClothStyles::where('id','!=',null)->pluck('order_clothes_id')->toArray(); 
        orderClothes::whereIn('id',$order_clothes_id)->update(['order_finished'=>null]);
        
        ClothStyles::truncate();
        return back()->with(['success'=>'تم حذف قصات القماش بنجاح']);
    }
}
