<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\client;
use App\category;
use App\order;
use App\reactionist;
use App\ClothStyles;
use DB;
class reactionistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $reactionist_count   = reactionist::count();
         return view('admin.reactionist.index')->with('reactionist_count',$reactionist_count);
    }

    function datatableReactionist(Request $request){
        $orderClothes = DB::table('reactionists')->get();
         return datatables()->of($orderClothes)
        ->addColumn('select', function($row) {

                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
            })
        ->addColumn('order_number', function($row) {
                if(empty($row->order_id))
                    return ' طلب غير موجود';

                 $order_id = order::where('order_id',$row->order_id)->pluck('order_follow')[0];
                 return '#'.($order_id->order_follow?$order_id->order_follow:$row->order_id);
            })
        ->addColumn('product_name', function($row) {
                 if($row->product_id):
                     return DB::table('products')->where('id',$row->product_id)->pluck('name_product')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('client_name', function($row) {
                 if($row->client_id):
                     return DB::table('clients')->where('id',$row->client_id)->pluck('client_name')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('category_name', function($row) {
                 if(empty($row->product_id))
                     return 'لايوجد ';

                 $category_id = DB::table('products')->where('id',$row->product_id)->pluck('category_id')[0];
                 if($category_id):
                     return DB::table('categories')->where('id',$category_id)->pluck('category')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('reactionist_price', function($row) {
                 return $row->reactionist_price.' جنية';
            })
        ->addColumn('Quantity', function($row) {
                 return $row->order_count.' قطعة';
            })
        ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('reactionist-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('reactionists/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';

            })
        ->addColumn('show', function($row) {
                   return '<a href='.url('reactionists/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
            })
        ->rawColumns(['select','Quantity','order_number','reactionist_price','process','show'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createReactionists($order_id=null)
    {
        //
         $get_all_clients = client::all();
         $get_all_categories = category::all();
         $get_all_product = product::all();
         $get_order_info =null;
         if($order_id!=null):
            $get_order_info  = order::where('id',$order_id)->get();
         endif;
         $last_order_added = reactionist::orderby('created_at','desc')->first();
         return view('admin.reactionist.create')->with(['order_id'=>$order_id,'get_order_info'=>$get_order_info,'all_products'=>$get_all_product,'last_order'=>$last_order_added,'all_clients'=>$get_all_clients,'get_all_categories'=>$get_all_categories]);
    }
    /**
     * Show all orders for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function create(){
        return view('admin.reactionist.orders');
    }

    /**
     * Show all orders for creating a new resource datatable.
     *
     * @return \Illuminate\Http\Response
     */
    function datatableReactionistOrders(Request $request){
         $orderClothes = DB::table('orders')->get();
         return datatables()->of($orderClothes)
        ->addColumn('select', function($row) {

                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.($row->order_follow?$row->order_follow:$row->id);
            })
        ->addColumn('product_name', function($row) {
                 if($row->product_id):
                     return DB::table('products')->where('id',$row->product_id)->pluck('name_product')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('client_name', function($row) {
                 if($row->client_id):
                     return DB::table('clients')->where('id',$row->client_id)->pluck('client_name')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('category_name', function($row) {

                 $category_id = DB::table('products')->where('id',$row->product_id)->pluck('category_id')[0];
                 if($category_id):
                     return DB::table('categories')->where('id',$category_id)->pluck('category')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('order_price', function($row) {
                 return $row->order_price.' جنية';
            })
        ->addColumn('Quantity', function($row) {
                 return $row->order_count.' قطعة';
            })
        ->addColumn('process', function($row) {
                 return '<a href='.url('orders/'.$row->id.'/reactionists/create').' class="btn btn-warning btn-sm">اضافة مرتجع </a>';
            })
        ->addColumn('show', function($row) {
                 return '<a href='.url('orders/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
            })
        ->rawColumns(['select','process','show'])->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //

        $this->validate($request,[
            'product_id'=>'required',
            'order_id'=>'required',
            'order_count'=>'required',
            'reactionist_price'=>'required',
        ]);
        $data = $request->all();
        product::where('id', $request->input('product_id') )->increment('count_piecies',$request->input('order_count'));
        $cloth_style_id = product::where('id', $request->input('product_id') )->pluck('cloth_styles_id')[0];
        // ClothStyles::where('id', $cloth_style_id )->increment('count_piecies',$request->input('order_count'));
        $last_insert = new reactionist();
        $last_insert->product_id = $request->product_id;
        $last_insert->order_id   = $request->order_id;
        $last_insert->order_count= $request->order_count;
        $last_insert->reactionist_price= $request->reactionist_price;
        $last_insert->client_id  = $request->client_id;
        $last_insert->payment_type= $request->payment_type;
        $last_insert->final_cost  = $request->order_count * $request->reactionist_price;
        $last_insert->save();
        $orginal_count_pieceis = order::where('id',$id)->pluck('order_count')[0];
        $orginal_value_of_pieces = order::where('id',$id)->pluck('order_price')[0];
        $orginal_value_of_order_price = ($orginal_value_of_pieces/$orginal_count_pieceis);
        order::where('id', $id )->decrement('order_count',$request->input('order_count'));
        order::where('id', $id )->decrement('final_cost',$last_insert->final_cost);
        order::where('id', $id )->decrement('order_price',( $orginal_value_of_order_price*$request->order_count ) );
        return back()->with(['success'=>'تم اضافة المرتجع بنجاح','last_order'=>$last_insert]);
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
        $single_reactionist = reactionist::where('id',$id)->get();
        $order_id = reactionist::where('id',$id)->pluck('order_id')[0];
        $order          = order::where('id',$order_id)->get();
        return view('admin.reactionist.single')->with(['reactionist_id'=>$id,'reactionist_data'=>$single_reactionist,'order'=>$order]);

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
        $get_all_clients = client::all();
        $get_all_categories = category::all();
        $get_all_products = product::all();
        $order_product_info = reactionist::where('id',$id)->get();
        return view('admin.reactionist.edite')->with(['get_all_products'=>$get_all_products,'order_product_info'=>$order_product_info,'all_clients'=>$get_all_clients,'get_all_categories'=>$get_all_categories]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$order_id)
    {
        //
         $this->validate($request,[
            'product_id'=>'required',
            'order_count'=>'required',
            'reactionist_price'=>'required',
            'payment_type'=>'required'
        ]);
         $request['final_cost']  = $request->order_count * $request->reactionist_price;
         if($request->input('old_order_count') != $request->input('order_count') ):
              $new_order_count = $request->input('order_count') - $request->input('old_order_count');
              product::where('id', $request->input('product_id') )->increment('count_piecies',$new_order_count);
              $cloth_style_id = product::where('id', $request->input('product_id') )->pluck('cloth_styles_id')[0];
             // ClothStyles::where('id', $cloth_style_id )->increment('count_piecies',$request->input('order_count'));
              order::where('id', $order_id )->decrement('order_count',$request->input('order_count'));
              order::where('id', $order_id )->decrement('final_cost',$request['final_cost']);
         endif;
        $last_insert = reactionist::where('id',$id)->update($request->only(['product_id','client_id','order_count','reactionist_price','payment_type','final_cost']));
        return back()->with(['success'=>'تم تعديل المرتجع بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$type_return=null)
    {
        //
        $count_order = reactionist::where('id',$id)->pluck('order_count')[0];
        $product_id  = reactionist::where('id',$id)->pluck('product_id')[0];
        $order_id    = reactionist::where('id',$id)->pluck('order_id')[0];
        $final_cost  = reactionist::where('id',$id)->pluck('final_cost')[0];
        product::where('id',$product_id)->decrement('count_piecies',$count_order);
        $cloth_style_id = product::where('id', $product_id )->pluck('cloth_styles_id')[0];
        // ClothStyles::where('id', $cloth_style_id )->decrement('count_piecies',$count_order);

        order::where('id', $order_id )->increment('order_count',$count_order);
        order::where('id', $order_id )->increment('final_cost',$final_cost);


        /*$reactionist_price = reactionist::where('id',$id)->pluck('reactionist_price')[0];
        $order_id          = reactionist::where('id',$id)->pluck('order_id')[0];
        $cloth_style_id    = product::where('id', $product_id )->pluck('cloth_styles_id')[0];
        order::where('id',$order_id)->decrement('order_count',$count_order);
        order::where('id',$order_id)->decrement('final_cost',$reactionist_price*$count_order);
       */

        reactionist::where('id',$id)->delete();
        if($type_return!=null){
             return redirect('show-reactionist')->with(['success'=>'تم حذف المرتجع بنجاح']);
        }
        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
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
        $count_order = reactionist::whereIn('id',$request->input('select'))->pluck('order_count')->toArray();
        $final_cost  = reactionist::whereIn('id',$request->input('select'))->pluck('final_cost')->toArray();
        $order_id    = reactionist::whereIn('id',$request->input('select'))->pluck('order_id')->toArray();
        $product_id  = reactionist::whereIn('id',$request->input('select'))->pluck('product_id')->toArray();
        if(!empty($count_order) &&  !empty($product_id) ):
             foreach ($count_order as $key => $value) :
                product::where('id',$product_id[$key])->decrement('count_piecies',$value);
                $cloth_style_id = product::where('id', $product_id[$key] )->pluck('cloth_styles_id')[0];
             //   ClothStyles::where('id', $cloth_style_id )->decrement('count_piecies',$value);

                order::where('id', $order_id[$key] )->increment('order_count',$value);
                order::where('id', $order_id[$key] )->increment('final_cost',$final_cost[$key]);



             endforeach;
        endif;
        /*product::where('id',$product_id)->decrement('count_piecies',$count_order);*/
        reactionist::whereIn('id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
    }

    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        $all_count = reactionist::all();
        if(!empty($all_count)):
             foreach ($all_count as $key => $value):
                  product::where('id',$value->product_id)->decrement('count_piecies',$value->order_count);
                  $cloth_style_id = product::where('id', $value->product_id )->pluck('cloth_styles_id')[0];
                  // ClothStyles::where('id', $cloth_style_id )->decrement('count_piecies',$value->order_count);


                 order::where('id', $value->order_id )->increment('order_count',$value->order_count);
                 order::where('id', $value->order_id )->increment('final_cost' ,$value->final_cost);

             endforeach;
        endif;
        reactionist::truncate();
        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
    }
}
