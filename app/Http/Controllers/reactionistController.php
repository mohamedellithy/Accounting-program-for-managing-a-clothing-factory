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
        $reactionists = reactionist::all();
        return datatables()->of($reactionists)
            ->addColumn('select', function($row){
                    return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.$row->id;
                })
            ->addColumn('invoice_no', function($row){
                    return $row->order->invoice_no;
                })
            ->addColumn('product_name', function($row) {
                    return $row->order->product->name_product;

                })
            ->addColumn('client_name', function($row){
                    return $row->order->client->client_name ?? 'بدون';
                })
            ->addColumn('category_name', function($row){
                    return $row->order->product->category->category;
                })
            ->addColumn('reactionist_price', function($row){
                    return $row->one_item_price.' جنية';
                })
            ->addColumn('Quantity', function($row){
                    return $row->order_count.' قطعة';
                })
             ->addColumn('final_cost', function($row){
                    return $row->final_cost.' جنية';
                })
            ->addColumn('process', function($row){
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
            ->rawColumns(['select','invoice_no','final_cost','product_name','client_name','category_name','reactionist_price','Quantity','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createReactionists($order_id=null)
    {
        //

        $order            = order::find($order_id);
        $last_order_added = reactionist::latest()->first();
        $Context = [
             'order'             =>$order,
             'last_order'        =>$last_order_added,
        ];
        return view('admin.reactionist.create')->with($Context);
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
        $orderClothes = order::whereNull('order_follow')->get();
        return datatables()->of($orderClothes)
            ->addColumn('select', function($row) {
                    return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.($row->order_follow?$row->order_follow:$row->id);
                })
            ->addColumn('invoice_no', function($row) {
                    return $row->invoice_no;
                })
            ->addColumn('product_name', function($row) {
                    return implode(' - ' , $row->invoices_products_name);
                })
            ->addColumn('client_name', function($row) {
                   return $row->client->client_name ?? 'لم يحدد';
                })
            ->addColumn('category_name', function($row) {
                   return implode(' - ' , $row->invoices_categories_name);
                })
            ->addColumn('order_price', function($row) {
                   return round($row->total_invoices,2).' جنية';
                })
            ->addColumn('Quantity', function($row) {
                    return implode(' قطعة  - ', $row->invoices_quantity).' قطعة ';
                })
            ->addColumn('process', function($row) {
                    return '<a href='.url('orders/'.$row->id.'/reactionists/create').' class="btn btn-warning btn-sm">اضافة مرتجع </a>';
                })
            ->addColumn('show', function($row) {
                    return '<a href='.url('orders/'.$row->id).' class="btn btn-success btn-sm">عرض </a>';
                })
            ->rawColumns(['select','product_name','client_name','category_name','order_price','Quantity','process','show'])->make(true);
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
        $order = order::find($request->order_id);

        $this->validate($request,[
            'order_id'      =>'required',
            'order_count'   =>'required|gte:1|lte:'.$order->order_count,
            'one_item_price'=>'required',
            'final_cost'    =>'required',
        ]);
        $order->product->increment('count_piecies',$request->order_count);
        $request['profit_order']    = $order->order_taxs * $request->order_count;
        $reactionist = reactionist::create($request->all());
        return back()->with(['success'=>'تم اضافة المرتجع بنجاح','last_order'=>$reactionist]);
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
        $single_reactionist = reactionist::find($id);
        return view('admin.reactionist.single')->with([
            'reactionist_data'=>$single_reactionist,
        ]);

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
        $reactionist = reactionist::find($id);
        $order       = $reactionist->order->parent_order;
        return view('admin.reactionist.edite')->with(['order'=>$order,'reactionist'=>$reactionist]);

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
        $reactionist = reactionist::find($id);
        $this->validate($request,[
            'order_id'      =>'required',
            'order_count'   =>'required|gte:1|lte:'.$reactionist->order->order_count,
            'one_item_price'=>'required',
            'final_cost'    =>'required',
        ]);
        if($reactionist->order_count > $request->order_count){
            $reactionist->order->product->decrement('count_piecies',($reactionist->order_count - $request->order_count));
        }
        elseif($reactionist->order_count < $request->order_count){
            $reactionist->order->product->increment('count_piecies',($request->order_count - $reactionist->order_count));
        }
        $order = order::find($request->order_id);
        $request['profit_order']    = $order->order_taxs * $request->order_count;
        $reactionist->update([
            'order_id'       => $request->order_id,
            'order_count'    => $request->order_count,
            'one_item_price' => $request->one_item_price,
            'final_cost'     => $request->final_cost,
            'profit_order'   => $request->profit_order,
        ]);
        return back()->with(['success'=>'تم تعديل المرتجع بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reactionist = reactionist::find($id);
        $reactionist->order->product->decrement('count_piecies',$reactionist->order_count);
        $reactionist->delete();
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

        $reactionists = reactionist::whereIn('id',$request->input('select'))->get();

        $reactionists->map(function($reactionist,$key){
            $reactionist->order->product->decrement('count_piecies',$reactionist->order_count);
            $reactionist->delete();
        });

        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
    }

    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        $reactionists = reactionist::all();

        $reactionists->map(function($reactionist,$key){
            $reactionist->order->product->decrement('count_piecies',$reactionist->order_count);
        });

        reactionist::truncate();
        return back()->with(['success'=>'تم حذف المرتجع بنجاح']);
    }
}
