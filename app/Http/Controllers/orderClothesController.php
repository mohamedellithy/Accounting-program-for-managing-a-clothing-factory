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
          $orderClothes_all   = orderClothes::count();
          $orderClothes_cash  = orderClothes::where('payment_type','نقدى')->count();
          $orderClothes_check  = orderClothes::where('payment_type','شيك')->count();
          $orderClothes_postponed  = orderClothes::where('payment_type','دفعات')->count();
        return view('admin.clothes.index')->with(['orderClothes_check'=>$orderClothes_check,'orderClothes_postponed'=>$orderClothes_postponed,'orderClothes_cash'=>$orderClothes_cash,'orderClothes_all'=>$orderClothes_all]);
    }

     /**
     * Display a all merchants in datatable
     *
     * @return \Illuminate\Http\Response
     */
    public function datatableorderClothes(Request $request){
        $orderClothes = DB::table('order_clothes')->orderby('created_at','desc')->get();
         return datatables()->of($orderClothes)
        ->addColumn('select', function($row) {

                 return '<input name="select[]" value="'.$row->id.'" type="checkbox"> #'.($row->order_follow?$row->order_follow:$row->id);
            })
        ->addColumn('merchant_name', function($row) {
                 return DB::table('merchants')->where('id',$row->merchant_id)->pluck('merchant_name')[0];
            })
        ->addColumn('category_name', function($row) {
                 return DB::table('categories')->where('id',$row->category_id)->pluck('category')[0];
            })
        ->addColumn('order_price', function($row) {
                 return $row->order_price.' جنية';
            })
         ->addColumn('order_discount', function($row) {
                 return ($row->order_discount?$row->order_discount:'0').' %';
            })
        ->addColumn('Quantity', function($row) {
                 return $row->order_size.' '.$row->order_size_type;
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
                              <a class="dropdown-item " href="'.url('order-clothes-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })->addColumn('show', function($row) {
                   return '<a href='.url('single-order-clothes/'.($row->order_follow?$row->order_follow:$row->id)).' class="btn btn-success btn-sm">عرض </a>';                
            })->rawColumns(['select','order_discount','process','show'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

         $get_all_merchants = merchant::all();
         $get_all_categories = category::all();
         $last_order_added = orderClothes::orderby('created_at','desc')->first();
         return view('admin.clothes.create')->with(['last_order'=>$last_order_added,'all_merchants'=>$get_all_merchants,'get_all_categories'=>$get_all_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $final_cost_of_order = 0;
        $payed_value         = 0;
        //
      //  dd($request->all());
        $this->validate($request,[
            'merchant_id'=>'required',
            'category_id'=>'required',
            'order_size_type'=>'required',
            'order_size'=>'required',
            'order_price'=>'required',
            'price_one_piecies'=>'required',
            'payment_type'=>'required'
        ]);
        $data = $request->all();
        $last_insert = orderClothes::create($request->all());
        $final_cost_of_order = $request->order_price;
        if($request->payment_type=='شيك'){
            $count_data_check = count($request->check_owner);
            if( $count_data_check!=0 ){
                for($input_value=0;$input_value<$count_data_check;$input_value++){
                    if(!empty($request->input('check_owner')[$input_value])):
                        $payed_value +=$request->input('check_value')[$input_value]+$request->input('increase_value')[$input_value];
                        $insert_bankcheck = new BankCheck();
                        $insert_bankcheck->bank_checkable_id = $last_insert->merchant_id;
                        $insert_bankcheck->bank_checkable_type = 'merchant';
                        $insert_bankcheck->check_date  = $request->input('check_date')[$input_value];
                        $insert_bankcheck->check_value = $request->input('check_value')[$input_value];
                        $insert_bankcheck->increase_value = $request->input('increase_value')[$input_value];
                        $insert_bankcheck->check_owner = $request->input('check_owner')[$input_value];
                        $insert_bankcheck->save();
                    endif;
                }
            }
        }
        elseif($request->payment_type=='دفعات'){
                $payed_value =  $request->input('postponed_value');
                $insert_postponed = new postponed_orderClothes();
                $insert_postponed->merchant_id = $last_insert->merchant_id;
                $insert_postponed->posponed_value = $request->input('postponed_value');
                $insert_postponed->save();         
        }

         $check_if_other_order_find = ($request->other_category_id?count($request->other_category_id):0);
         if($check_if_other_order_find!=0){
            for($counter=0;$counter<$check_if_other_order_find;$counter++){
                $final_cost_of_order += $request->other_order_price[$counter];
                $insert_other_order = new orderClothes();
                $insert_other_order->merchant_id   = $last_insert->merchant_id;
                $insert_other_order->category_id   = $request->other_category_id[$counter];
                $insert_other_order->order_size    = $request->other_order_size[$counter];
                $insert_other_order->order_size_type = $request->other_order_size_type[$counter];
                $insert_other_order->order_price   = $request->other_order_price[$counter];
                $insert_other_order->payment_type  = $last_insert->payment_type;
                $insert_other_order->price_one_piecies  = $request->other_price_one_piecies[$counter];
                $insert_other_order->order_discount     = $request->other_order_discount[$counter];
                $insert_other_order->order_follow  = $last_insert->id;
                $insert_other_order->save();    
            }

         }

        // here do any thing 
         if($payed_value>$final_cost_of_order):
            insert_debit_data($request->merchant_id,'merchant','دائن',($payed_value-$final_cost_of_order),$request->payment_type,$last_insert->id);
         endif;
        return back()->with(['success'=>'تم اضافة الطلب بنجاح','last_order'=>$last_insert]);
    
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
        $single_order = orderClothes::where('id',$id)->get();
        $other_orders_in_order = orderClothes::where('order_follow',$id)->get();
        $merchant_id  = orderClothes::where('id',$id)->pluck('merchant_id')[0];
        $merchant_data= merchant::where('id',$merchant_id)->get();
      /*  $bank_check_info = BankCheck::where(['bank_checkable_id'=>$id,'bank_checkable_type'=>'orderClothes'])->get();
        $postponed_data  = postponed_orderClothes::where('orderClothes_id',$id)->get();*/
        return view('admin.clothes.single')->with(['other_orders_in_order'=>$other_orders_in_order,'order_id'=>$id,'order_data'=>$single_order,'merchant_data'=>$merchant_data]);

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
        $get_all_merchants = merchant::all();
        $get_all_categories = category::all();
        $order_clothes_info = orderClothes::with('bank_check')->where('id',$id)->get();
        
        return view('admin.clothes.edite')->with(['order_clothes_info'=>$order_clothes_info,'all_merchants'=>$get_all_merchants,'get_all_categories'=>$get_all_categories]);

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
            'payment_type'=>'required'
        ]);
        $last_insert = orderClothes::where('id',$id)->update($request->only(['merchant_id','category_id','order_size_type','order_size','order_price','payment_type','price_one_piecies']));
        
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
        orderClothes::where('id',$id)->delete();
        //BankCheck::where(['bank_checkable_id'=>$id,'bank_checkable_type'=>'orderClothes'])->delete();
        //postponed_orderClothes::where('orderClothes_id',$id)->delete();
        if($type_return=='single'){
            return redirect('show-orders-clothes');
        }
        else{
            return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
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
        orderClothes::whereIn('id', $request->input('select') )->delete();
       // BankCheck::whereIn('bank_checkable_id',$request->input('select'))->where('bank_checkable_type','orderClothes')->delete();
      //  postponed_orderClothes::whereIn('orderClothes_id',$request->input('select'))->delete();
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
        //BankCheck::where('bank_checkable_type','orderClothes')->delete();
        //postponed_orderClothes::truncate();
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
