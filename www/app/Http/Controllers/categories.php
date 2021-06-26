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
          $category  = category::all();
          # all category finished
          $category_finished_order_count   = DB::table('order_clothes')->where('order_finished',true)->distinct()->count();
          # all category finished product
          $category_finished_order_count   = DB::table('products')->where('count_piecies',0)->distinct()->count();
          # last added merchant
          $categories_last_added           = category::where('created_at', '>=', Carbon::now()->firstOfMonth()->toDateTimeString() )->count();
          $Context = [
             'categories_last_added'        =>$categories_last_added,
             'category_finished_order_count'=>$category_finished_order_count,
             'categories_count'             =>$category->count(),
             'category_all'                 =>$category
          ];
          return view('admin.category.index')->with($Context);

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
                if( $count_order = orderClothes::where('category_id',$row->id)->count() ){
                    $type = "طلبية قماش";
                    return ($count_order?$count_order.' '.$type:'');
                }

                if($count_products = product::where('category_id',$row->id)->count()){
                    $type = "منتج";
                    return ( $count_products ? $count_products : '');
                }
                return '-';
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
                              <a class="dropdown-item " href="'.url('categories/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';

            })
            ->rawColumns(['select','count_orders','process'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $Context = [
            'last_category'=>category::latest()->first()
         ];
         return view('admin.category.create')->with($Context);
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
        $Context =[
           'success'      =>'تم اضافة التصنيف بنجاح',
           'last_category'=>$last_insert
        ];
        return back()->with($Context);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Context = [
           'category_data' => category::find($id)
        ];
        return view('admin.category.edite')->with($Context);

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
        category::where('id',$id)->update($request->only(['category']));
        $Context = [
          'success'=>'تم تعديل التصنيف بنجاح'
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
        category::destroy($id);
        $Context = [
            'success'=>'تم حذف التصنيف بنجاح'
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
        category::destroy($request->input('select'));
        $Context = [
            'success'=>'تم حذف التصنيف بنجاح'
        ];
        return back()->with($Context);
    }

    public function truncated(){
        category::truncate();
        return back()->with(['success'=>'تم حذف التصنيف بنجاح']);
    }
}
