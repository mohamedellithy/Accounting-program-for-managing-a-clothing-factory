<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\orderClothes;
use App\product;
use Carbon\Carbon;
use DB;
class categories extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $category_all  = category::all();

          // all merchants count
          $categories_count   = category::count();

          // all category finished
          $category_finished_order       = DB::table('order_clothes')->where('order_finished',true)->distinct()->pluck('category_id')->toArray();
          $category_finished_order_count = count($category_finished_order);
          
          // all category finished product
          $category_finished_product       = DB::table('products')->where('count_piecies',0)->distinct()->pluck('category_id')->toArray();
          $category_finished_order_count   = count($category_finished_product);
          
          // last added merchant   
          $categories_last_added           = category::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString() )->count();
         
          return view('admin.category.index')->with(['categories_last_added'=>$categories_last_added,'category_finished_order_count'=>$category_finished_order_count,'categories_count'=>$categories_count,'category_all'=>$category_all]);
         
    }
    

    /**
     * Display a all Categories in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableCategories(Request $request){
        $categories = DB::table('categories')->get();
         return datatables()->of($categories)
        ->addColumn('select', function($row) {
                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> '.$row->id.'#';


            })
            ->addColumn('count_orders', function($row) {
                $count_order = orderClothes::where('category_id',$row->id)->count();
                $type = "طلب";
                if(empty($count_order)){
                    $count_order = product::where('category_id',$row->id)->count();
                    $type = "منتج";
                }

                return ($count_order?$count_order.' '.$type:' فارغ ');
            })
            ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('category-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('category-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->rawColumns(['select','count_orders','process'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $last_category_added = category::orderby('created_at','desc')->first();
         //var_dump($last_merchant_added);
         return view('admin.category.create')->with(['last_category'=>$last_category_added]);
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
             'category' => 'required',
        ]);
        $last_insert = category::create($request->all());
        return back()->with(['success'=>'تم اضافة التصنيف بنجاح','last_category'=>$last_insert]);
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
        $category_data_info = category::where('id',$id)->get();
        return view('admin.category.edite')->with('category_data',$category_data_info);

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
             'category' => 'required',
        ]);
        $last_insert = category::where('id',$id)->update($request->only(['category']));
        return back()->with(['success'=>'تم تعديل التصنيف بنجاح']);
   
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
        category::where('id',$id)->delete();
        return back()->with(['success'=>'تم حذف التصنيف بنجاح']);
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
        category::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف التصنيف بنجاح']);
    }

    public function truncated(){
        category::truncate();
        return back()->with(['success'=>'تم حذف التصنيف بنجاح']);
    }
}
