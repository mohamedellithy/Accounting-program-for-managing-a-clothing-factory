<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use DB;
use App\category;
use App\ClothStyles;
class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $product_count     = product::count();
         $product_finished  = product::where('count_piecies',0)->count();
         $product_styles    = product::where('cloth_styles_id','!=',null)->count();
         $product_others    = product::where('cloth_styles_id',null)->count();
         
        return view('admin.products.index')->with(['product_styles'=>$product_styles,'product_others'=>$product_others,'product_count'=>$product_count,'product_finished'=>$product_finished,]);
    }
    public function datatableProducts(Request $request){
          $clothStyles = DB::table('products')->get();
         return datatables()->of($clothStyles)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox">';

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
                              <a class="dropdown-item delete_single" href="'.url('product-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('product-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-product/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','category','full_price_handle','count_piecies_handle','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $last_order_added = product::orderby('created_at','desc')->first();
        $get_all_categories = category::all();
        return view('admin.products.create')->with(['get_all_categories'=>$get_all_categories,'last_products'=>$last_order_added]);;
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
                'name_product'    =>'required',
                'category_id'     =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'required',
                'full_price'      =>'required',
        ]);
        $last_insert = product::create($request->all());
        return back()->with(['success'=>'تم اضافة المنتجات بنجاح','last_products'=>$last_insert]);
   
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

        $single_product = product::where('id',$id)->get();
        $clothes_style_id = product::where('id',$id)->pluck('cloth_styles_id')[0];
        $clothes_style  = ClothStyles::where('id',$clothes_style_id)->get();
        return view('admin.products.single')->with(['product_id'=>$id,'product_data'=>$single_product,'clothes_style'=>$clothes_style]);
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
          $product_info    = product::where('id',$id)->get();
          $get_all_categories = category::all();
         return view('admin.products.edite')->with(['product_info'=>$product_info,'get_all_categories'=>$get_all_categories]);
    
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
                'category_id'     =>'required',
                'name_product'    =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'',
                'full_price'      =>'required',
        ]);
        $last_insert = product::where('id',$id)->update($request->only(['category_id','name_piecies','count_piecies','price_piecies','additional_taxs','full_price']) );
        return back()->with(['success'=>'تم تعديل المنتجات بنجاح','last_ClothSyles'=>$last_insert]);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$type_return=null)
    {
        /*$clothes_styles_id = product::where('id',$id)->pluck('cloth_styles_id')[0];
        if($clothes_styles_id){
            ClothStyles::where('id',$clothes_styles_id)->update([''=>'']);
        }*/
        product::where('id',$id)->delete();
        if($type_return=='single'){
            return redirect('show-products');
        }
        else{
            return back()->with(['success'=>'تم حذف المنتجات بنجاح']);
       }
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
       
        product::whereIn('id', $request->input('select') )->delete();
        return back()->with(['success'=>'تم حذف المنتجات بنجاح']);
    }

     /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        product::truncate();
        return back()->with(['success'=>'تم حذف المنتجات بنجاح']);
    }
}
