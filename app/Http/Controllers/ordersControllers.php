<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\client;
use App\category;
use App\orderClothes;
use App\order;
use App\BankCheck;
use App\postponed;
use App\ClothStyles;
use DB;
class ordersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

          $order_all   = order::count();
          $order_cash  = order::where('payment_type','نقدى')->count();
          $order_check = order::where('payment_type','شيك')->count();
          $order_postponed  = order::where('payment_type','دفعات')->count();
          $Context = [
              'order_all'      =>$order_all,
              'order_cash'     =>$order_cash,
              'order_check'    =>$order_check,
              'order_postponed'=>$order_postponed
          ];
          return view('admin.orders.index')->with( $Context );

    }

    function datatableOrders(Request $request){
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
                    return '<div class="btn-group">
                                <button type="button" class="btn btn-warning">اجراء</button>
                                <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item delete_single" href="'.url('order-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item " href="'.url('orders/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                                </div>
                            </div>';

                })
            ->addColumn('invoice', function($row) {
                    return '<a href='.url('review-order/'.($row->order_follow?$row->order_follow:$row->id)).' class="btn btn-success btn-sm" style="background-color:#e91e63;border:1px solid #e91e63"> فاتورة </a>';
                })
            ->addColumn('show', function($row) {
                    return '<a href='.url('orders/'.($row->order_follow?$row->order_follow:$row->id)).' class="btn btn-success btn-sm">عرض </a>';
                })
            ->rawColumns(['select','invoice_no','product_name','category_name','order_prices','client_name','Quantity','process','invoice','show'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
         $get_all_clients    = client::all();
         $get_all_categories = category::all();
         $get_all_product    = product::all();
         $last_order_added   = order::where(['order_follow'=>null])->latest()->first();
         $Context = [
             'all_products'      =>$get_all_product,
             'last_order'        =>$last_order_added,
             'all_clients'       =>$get_all_clients,
             'get_all_categories'=>$get_all_categories
         ];
         return view('admin.orders.create')->with( $Context );
    }

    function Calculate_final_Cost($request){
        $cal_tax                = $request['order_taxs'] * $request['order_count'];
        $cal_full_cost_with_tax = $request['order_price'] + $cal_tax;
        return $cal_full_cost_with_tax - $request['order_discount'];

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
        $final_cost          = 0;
        $payed_value         = 0;
        $this->validate($request,[
            'product_id'=>'required',
            'order_count'=>'required',
            'order_price'=>'required',
            'payment_type'=>'required'
        ]);

        $request['invoice_no'] = strtotime(date('Y-m-d H:i:s')).rand(1,1000);

        $request['final_cost'] = $this->Calculate_final_Cost($request->only([
            'order_taxs',
            'order_count',
            'order_price',
            'order_discount'
        ]));
        $last_insert = order::create($request->all());

        $last_insert->product->decrement('count_piecies',$last_insert->order_count);
        # stop decrement count pieces in ClothesStyles
        # $last_insert->product->first()->clothes_styles->decrement('count_piecies',$last_insert->order_count);
        $final_cost = $request['final_cost'];

        # payment type  شيكات
        if( !empty($request->check_value)  && ($request->payment_type=='شيك')):

            if( $count_data_check = count($request->check_owner) > 0 ):

                for($input_value=0; $input_value < $count_data_check; $input_value++):
                    if(!empty($request->input('check_owner')[$input_value])):
                        $payed_value += $request->input('check_value')[$input_value] + $request->input('increase_value')[$input_value];
                        bankCheckController::Create([
                           'id'             => $last_insert->client_id,
                           'type'           =>'client',
                           'check_date'     => $request->input('check_date')[$input_value],
                           'check_value'    => $request->input('check_value')[$input_value],
                           'increase_value' => $request->input('increase_value')[$input_value],
                           'check_owner'    => $request->input('check_owner')[$input_value],
                        ]);
                    endif;
                endfor;
            endif;

        # payment type  دفعات
        elseif( !empty($request->postponed_value) && ($request->payment_type=='دفعات')):
            if(!empty($request->input('postponed_value') )):

                $payed_value =  $last_insert->postponed_value;
                # add  payments to merchant from
                ClientPayments::Create($last_insert->client_id,ClientPayments::PaymentValue($last_insert->client_id,$last_insert->postponed_value,'دفعات'));

            endif;
        endif;

        # here if attach others order in invoice
        if( !empty($request->other_product_id) && ($attach_Orders = count($request->other_product_id) > 0) ){
            for($counter = 0; $counter < $attach_Orders ; $counter++ ){
                $final_cost += self::CreateOthersOrders($request,$last_insert,$counter);
            }
        }


        # here payed vales is greater than
        if( $payed_value > $final_cost ):
            debitController::insert_debit_data([
                'debiter_id'     => $last_insert->client_id,
                'section'        => 'client',
                'value'          => 'مدين',
                'type_debit'     => $payed_value - $final_cost,
                'type_payment'   => $last_insert->payment_type,
                'order_id'       => $last_insert->id,
            ]);
        endif;

        return redirect('review-order/'.$last_insert->id)->with(['success'=>'تم اضافة الطلب بنجاح','last_order'=>$last_insert]);
    }

    public static function CreateOthersOrders(object $data , $parentOrder , $counter){
        $final_cost_of_order = ($data['other_order_price'][$counter] + ($data['other_order_taxs'][$counter] * $data['other_order_count'][$counter])) - $data['other_order_discount'][$counter];
        $insert_other_order = new order();
        $insert_other_order->client_id       = $parentOrder->client_id;
        $insert_other_order->invoice_no      = $parentOrder->invoice_no;
        $insert_other_order->product_id      = $data['other_product_id'][$counter];
        $insert_other_order->order_discount  = $data['other_order_discount'][$counter];
        $insert_other_order->order_count     = $data['other_order_count'][$counter];
        $insert_other_order->order_price     = $data['other_order_price'][$counter];
        $insert_other_order->payment_type    = $parentOrder->payment_type;
        $insert_other_order->order_taxs      = $data['other_order_taxs'][$counter];
        $insert_other_order->final_cost      = $final_cost_of_order;
        $insert_other_order->order_follow    = $parentOrder->id;
        $insert_other_order->save();
        $insert_other_order->product->decrement('count_piecies',$data->other_order_count[$counter]);
        # stop decrement count pieces in ClothesStyles
        # $insert_other_order->product->clothes_styles->decrement('count_piecies',$data->other_order_count[$counter]);
        return $final_cost_of_order;
    }

    function review_order($id){
        $order_invoices = order::find($id);
        $Context = [
          'order_invoices' => $order_invoices
        ];
        return view('admin.orders.review')->with($Context);
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
        $single_order = order::find($id);
        $Context = [
            'order_data'           =>$single_order,
        ];
        return view('admin.orders.single')->with($Context);

    }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $get_all_clients    = client::all();
        $get_all_categories = category::all();
        $get_all_products   = product::all();
        $order_product_info = order::find($id);
        $Context = [
            'get_all_products'  =>$get_all_products,
            'order_info'        =>$order_product_info,
            'all_clients'       =>$get_all_clients,
            'get_all_categories'=>$get_all_categories
        ];

        return view('admin.orders.edite')->with( $Context );
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
            'product_id'  =>'required',
            'order_count' =>'required',
            'order_price' =>'required',
            'payment_type'=>'required'
        ]);
        $orders = order::where('id',$id)->orwhere('order_follow',$id)->get();
        $orders->map(function($order,$key) use($request){

            # increament or decrement count piecies
            if($order->order_count  > $request->order_count[$key]):
                $order->product->increment('count_piecies',( $order->order_count - $request->order_count[$key] ));
            elseif($order->order_count  < $request->order_count[$key]):
                $order->product->decrement('count_piecies',( $request->order_count[$key] - $order->order_count ));
            endif;

            # here update order items in invoice
            $order->update([
                 'client_id'      => $request->client_id           ?? $request->client_id,
                 'product_id'     => $request->product_id[$key]    ?? $request->product_id[$key],
                 'order_count'    => $request->order_count[$key]   ?? $request->order_count[$key],
                 'order_price'    => $request->product_id[$key]    ?? $request->product_id[$key],
                 'payment_type'   => $request->payment_type        ?? $request->payment_type,
                 'order_taxs'     => $request->order_taxs[$key]    ?? $request->order_taxs[$key],
                 'order_price'    => $request->order_price[$key]   ?? $request->order_price[$key],
                 'order_discount' => $request->order_discount[$key]?? $request->order_discount[$key],
                 'product_id'     => $request->product_id[$key]    ?? $request->product_id[$key],
                 'order_follow'   => $order->order_follow          ?? $order->order_follow,
                 # here set final cost
                 'final_cost'     => $this->Calculate_final_Cost([
                     'order_taxs'     => $request->order_taxs[$key],
                     'order_count'    => $request->order_count[$key],
                     'order_price'    => $request->order_price[$key],
                     'order_discount' => $request->order_discount[$key],
                 ]),
            ]);
        });

        return back()->with(['success'=>'تم تعديل الطلبية بنجاح']);

    }


    function add_orders_sale_postponed(Request $request, $id){
        $payed_value         = postponed::where('order_id',$id)->sum('posponed_value');
        $final_cost_of_order = order::where('id',$id)->orWhere('order_follow',$id)->sum('final_cost');
        $client_id           = order::where('id',$id)->pluck('client_id')[0];
        if(($payed_value < $final_cost_of_order) && ( ($final_cost_of_order-$payed_value) >= $request->input('postponed_value') )  ):
            $insert_postponed = new postponed();
            $insert_postponed->order_id = $id;
            $insert_postponed->posponed_value = $request->input('postponed_value');
            $insert_postponed->save();
            $payed_value+=$request->input('postponed_value');
            if($payed_value>$final_cost_of_order):
                insert_debit_data($client_id,'client','مدين',($payed_value-$final_cost_of_order),'دفعات',$id);
            endif;
        endif;
        return back()->with(['success'=>'تم اضافة دفعات بنجاح']);
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
        $orders = order::where('id',$id)->orWhere('order_follow',$id)->get();
        $orders->map(function($order,$key){
            $order->product->increment('count_piecies',$order->order_count);
            $order->delete();
        });
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
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

        $orders = order::whereIn('id',$request->input('select'))->OrwhereIn('order_follow',$request->input('select'))->get();
        $orders->map(function($order,$key){
            $order->product->increment('count_piecies',$order->order_count);
            $order->delete();
        });
        return back()->withErrors(['error_delete'=>'تم حذف الطلبات بنجاح']);
    }

    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){

        $orders = order::all();
        $orders->map(function($order,$key){
            $order->product->increment('count_piecies',$order->order_count);
            $order->delete();
        });
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
    }
}
