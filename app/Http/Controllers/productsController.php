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
         $Context = [
             'product_styles'  =>$product_styles,
             'product_others'  =>$product_others,
             'product_count'   =>$product_count,
             'product_finished'=>$product_finished
        ];

        return view('admin.products.index')->with( $Context );
    }

    public function datatableProducts(Request $request){
        $clothStyles = product::all();
        return datatables()->of($clothStyles)
            ->addColumn('select', function($row) {
                    return '<input name="select[]" value="'.$row->id.'" type="checkbox">';
                })
            ->addColumn('category', function($row) {
                if($row->category->exists){
                    return $row->category->category;
                }
            })
            ->addColumn('full_price_handle',function($row){
                return $row->price_piecies + $row->additional_taxs.' جنيه ';
            })
            ->addColumn('count_piecies_handle',function($row){
                return $row->count_piecies.' قطعة ';
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
                            <a class="dropdown-item delete_single" href="'.url('product-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " href="'.url('products/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';
            })
            ->addColumn('show', function($row) {
                return '<a href='.url('products/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
            })
            ->rawColumns(['select','category','full_price_handle','count_piecies_handle','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $last_order_added = product::latest()->first();
        $get_all_categories = category::all();
        $Context = [
            'get_all_categories'=>$get_all_categories,
            'last_products'     =>$last_order_added
        ];
        return view('admin.products.create')->with($Context);
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
        #here generate parcode
        $request['parcode']  = strtotime(date('Y-m-d h:i:s')).rand(1,1000);
        $last_insert = product::create($request->all());
        $Context = [
            'success'      =>'تم اضافة المنتجات بنجاح',
            'last_products'=>$last_insert
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

        $single_product = product::find($id);
        $Context = [
            'product_data' =>$single_product,
        ];
        return view('admin.products.single')->with($Context);
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
          $product_info       = product::find($id);
          $get_all_categories = category::all();
          $Context = [
              'product'           =>$product_info,
              'get_all_categories'=>$get_all_categories
          ];
          return view('admin.products.edite')->with($Context);

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
        $this->validate($request,[
                'category_id'     =>'required',
                'name_product'    =>'required',
                'count_piecies'   =>'required',
                'price_piecies'   =>'required',
                'additional_taxs' =>'',
                'full_price'      =>'required',
        ]);
        $last_insert = product::where('id',$id)->update($request->only(['category_id','name_piecies','count_piecies','price_piecies','additional_taxs','full_price']) );
        $Context = [
            'success'        =>'تم تعديل المنتجات بنجاح',
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
    public function destroy($id,$type_return=null)
    {
        product::destroy($id);
        return back()->with(['success'=>'تم حذف المنتجات بنجاح']);
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

        product::destroy($request->input('select') );
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

    public static function CreateProduct($data){
        $insert_product = new product();
        $insert_product->parcode         = strtotime(date('Y-m-d h:i:s')).rand(1,1000);
        $insert_product->category_id     = $data['category_id'];
        $insert_product->name_product    = $data['name_piecies'];
        $insert_product->price_piecies   = $data['price_piecies'];
        $insert_product->count_piecies   = $data['count_piecies'];
        $insert_product->additional_taxs = $data['additional_taxs'];
        $insert_product->full_price      = $data['full_price'];
        $insert_product->save();
        return $insert_product;

    }
}
