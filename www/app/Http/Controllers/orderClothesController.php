<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\merchant;
use App\category;
use App\orderClothes;
use App\BankCheck;
use DB;
use App\postponed_orderClothes;
class orderClothesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $orderClothes_all        = orderClothes::count();
          $orderClothes_cash       = orderClothes::where('payment_type','نقدى')->count();
          $orderClothes_check      = orderClothes::where('payment_type','شيك')->count();
          $orderClothes_postponed  = orderClothes::where('payment_type','دفعات')->count();
          $Context = [
            'orderClothes_check'    =>$orderClothes_check,
            'orderClothes_postponed'=>$orderClothes_postponed,
            'orderClothes_cash'     =>$orderClothes_cash,
            'orderClothes_all'      =>$orderClothes_all
          ];
          return view('admin.clothes.index')->with($Context);
    }

     /**
     * Display a all merchants in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableorderClothes(Request $request){
        $orderClothes = orderClothes::whereNull('order_follow')->get();
        return datatables()->of($orderClothes)
            ->addColumn('select', function($row) {
                    return '<input name="select[]" value="'.$row->id.'" type="checkbox"> ';
                })
            ->addColumn('id',function($row) {
                    return '#'.($row->order_follow?$row->order_follow:$row->id);
            })
            ->addColumn('merchant_name', function($row) {
                    return $row->merchant->merchant_name;
                })
            ->addColumn('category_name', function($row) {
                    return $row->attached_orders_category;
                })
            ->addColumn('order_price', function($row) {
                    return $row->total_invoice.' جنية';
                })
            ->addColumn('order_discount', function($row) {
                    return ($row->attached_orders_discounts ? $row->attached_orders_discounts.'%':' بدون ');
                })
            ->addColumn('Quantity', function($row) {
                    return $row->attached_orders_size.' '.$row->order_size_type;
                })
            ->addColumn('process', function($row) {
                 return '<div class="btn-group">
                            <button type="button" class="btn btn-warning">اجراء</button>
                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item delete_single" href="'.url('order-clothes-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('orders-clothes/'.$row->id.'/edit').'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>
                            </div>
                        </div>';
            })
            ->addColumn('show', function($row) {
                   return '<a href='.url('orders-clothes/'.($row->order_follow?$row->order_follow:$row->id)).' class="btn btn-success btn-sm">عرض </a>';
            })
            ->rawColumns(['select','id','merchant_name','category_name','order_price','Quantity','order_discount','process','show'])->make(true);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         $get_all_merchants = merchant::all();
         $get_all_categories = category::all();
         $last_order_added = orderClothes::latest()->first();
         $Context = [
             'last_order'        => $last_order_added,
             'all_merchants'     => $get_all_merchants,
             'get_all_categories'=> $get_all_categories
         ];
         return view('admin.clothes.create')->with($Context);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $final_cost          = 0;
        $payed_value         = 0;
        $this->validate($request,[
            'merchant_id'=>'required',
            'category_id'=>'required',
            'order_size_type'=>'required',
            'order_size'=>'required',
            'order_price'=>'required',
            'price_one_piecies'=>'required',
            'payment_type'=>'required'
        ]);
        $last_insert = orderClothes::create($request->all());
        $final_cost  = $last_insert->order_price;

        # payment type  شيكات
        if( !empty($request->check_value)  && ($request->payment_type=='شيك')):

            if( $count_data_check = count($request->check_owner) > 0 ):
                for($input_value = 0; $input_value < $count_data_check; $input_value++ ):
                    if(!empty($request->input('check_owner')[$input_value])):
                        $payed_value += $request->input('check_value')[$input_value] + $request->input('increase_value')[$input_value];
                        bankCheckController::Create([
                           'id'             => $last_insert->merchant_id,
                           'type'           =>'merchant',
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
            $payed_value =  $last_insert->postponed_value;
            # add  payments to merchant from
            MerchantPayments::Create($last_insert->merchant_id,MerchantPayments::PaymentValue($last_insert->merchant_id,$last_insert->postponed_value,'دفعات'));
        endif;

        # here if attach others order in invoice
        if( !empty($request->other_category_id) && ($attach_Orders = count($request->other_category_id) > 0) ){
            for($counter = 0; $counter < $attach_Orders ; $counter++ ){
                $final_cost += self::CreateOthersOrders($request,$last_insert,$counter);
            }
        }

        # here payed vales is greater than
        if( $payed_value > $final_cost ):
            debitController::insert_debit_data([
                'debiter_id'     => $last_insert->merchant_id,
                'section'        => 'merchant',
                'value'          => 'دائن',
                'type_debit'     => $payed_value - $final_cost,
                'type_payment'   => $last_insert->payment_type,
                'order_id'       => $last_insert->id,
            ]);
        endif;

        # if merchant have debit  decrement it from new order
        # if($last_insert->merchant->debits()->sum(DB::raw('debit_value - debit_paid')) > 0 ){
        #     $last_insert->merchant->debits()
        #     ->where('debit_value','debit_paid')
        #     ->get()->map(function($value,$key) use($final_cost){
        #         $rest = $value->debit_value - $value->debit_paid
        #         if($rest < $final_cost){
        #             $value->increment('debit_paid',$rest);
        #         }
        #     })
        # }

        return back()->with(['success'=>'تم اضافة الطلب بنجاح','last_order'=>$last_insert]);

    }

    static function CreateOthersOrders(object $data , $parentOrder , $counter){
        $insert_other_order = new orderClothes();
        $insert_other_order->merchant_id        = $parentOrder->merchant_id;
         $insert_other_order->invoice_no        = $parentOrder->invoice_no;
        $insert_other_order->category_id        = $data['other_category_id'][$counter];
        $insert_other_order->order_size         = $data['other_order_size'][$counter];
        $insert_other_order->order_size_type    = $data['other_order_size_type'][$counter];
        $insert_other_order->order_price        = $data['other_order_price'][$counter];
        $insert_other_order->payment_type       = $parentOrder->payment_type;
        $insert_other_order->price_one_piecies  = $data['other_price_one_piecies'][$counter];
        $insert_other_order->order_discount     = $data['other_order_discount'][$counter];
        $insert_other_order->order_follow       = $parentOrder->id;
        $insert_other_order->save();
        return $data['other_order_price'][$counter];
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
        $invoice = orderClothes::find($id);
        $Context = [
            'invoice'=>$invoice,
        ];
        return view('admin.clothes.single')->with($Context);

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
        $merchants     = merchant::all();
        $categories    = category::all();
        $order_clothes = orderClothes::find($id);
        $Content = [
            'order_clothes'     =>$order_clothes,
            'merchants'     =>$merchants,
            'categories'=>$categories
        ];
        return view('admin.clothes.edite')->with($Content);

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
            'merchant_id'=>'required',
            'category_id'=>'required',
            'order_size_type'=>'required',
            'order_size'=>'required',
            'order_price'=>'required',
            'price_one_piecies'=>'required',
        ]);
        $orderClothes = orderClothes::where('id',$id)->orWhere('order_follow',$id)->get();
        $orderClothes->map(function($value,$key) use($request){
            orderClothes::where('id',$value->id)->update([
               'merchant_id'      =>$request->merchant_id,
               'invoice_no'       =>$request->invoice_no,
               'payment_type'     =>$request->payment_type,
               'category_id'      =>$request->category_id[$key],
               'order_size_type'  =>$request->order_size_type[$key],
               'order_size'       =>$request->order_size[$key],
               'order_price'      =>$request->order_price[$key],
               'price_one_piecies'=>$request->price_one_piecies[$key],
            ]);
        });
        return back()->with(['success'=>'تم تعديل الطلبية بنجاح']);

    }

    function add_order_postponed(request $request ,$id){
        $payed_value         = postponed_orderClothes::where('orderClothes_id',$id)->sum('posponed_value');
        $final_cost_of_order = orderClothes::where('id',$id)->orWhere('order_follow',$id)->sum('order_price');
        $merchant_id         = orderClothes::where('id',$id)->pluck('merchant_id')[0];
        if(($payed_value < $final_cost_of_order) && ( ($final_cost_of_order-$payed_value) >= $request->input('postponed_value') )  ):
            $insert_postponed = new postponed_orderClothes();
            $insert_postponed->orderClothes_id = $id;
            $insert_postponed->posponed_value = $request->input('postponed_value');
            $insert_postponed->save();
            $payed_value+=$request->input('postponed_value');
            if($payed_value>$final_cost_of_order):
                insert_debit_data($merchant_id,'merchant','دائن',($payed_value-$final_cost_of_order),'دفعات',$id);
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
        orderClothes::where('id',$id)->orWhere('order_follow',$id)->delete();
        $Context = [
            'success'=>'تم حذف الطلبية بنجاح'
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
        orderClothes::where('id',$request->input('select'))->orWhere('order_follow',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
    }

    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
        orderClothes::truncate();
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
    }


    function add_check_for_order(Request $request , $order_id){
        $insert_bankcheck = new BankCheck();
        $insert_bankcheck->bank_checkable_id = $order_id;
        $insert_bankcheck->bank_checkable_type = 'orderClothes';
        $insert_bankcheck->check_date  = $request->input('check_date');
        $insert_bankcheck->check_value = $request->input('check_value');
        $insert_bankcheck->increase_value = $request->input('increase_value');
        $insert_bankcheck->check_owner = $request->input('check_owner');
        $insert_bankcheck->save();
    }
}
