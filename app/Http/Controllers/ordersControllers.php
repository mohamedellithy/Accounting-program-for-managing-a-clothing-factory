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
       
        return view('admin.orders.index')->with(['order_all'=>$order_all,'order_cash'=>$order_cash,'order_check'=>$order_check,'order_postponed'=>$order_postponed]);
 
    }

    function datatableOrders(Request $request){
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
                 //return 'ok';
                 $category_id = DB::table('products')->where('id',$row->product_id)->pluck('category_id')[0];
                 if($category_id):
                     return DB::table('categories')->where('id',$category_id)->pluck('category')[0];
                 else:
                     return 'بدون';
                 endif;
            })
        ->addColumn('order_price', function($row) {
                 return round($row->order_price,2).' جنية';
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
                              <a class="dropdown-item delete_single" href="'.url('order-delete/'.$row->id).'"  data-toggle="modal" data-target="#modal-default"> <i class="far fa-trash-alt"></i>  حذف</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item " href="'.url('order-edite/'.$row->id).'"> <i class="fas fa-pencil-alt"></i>  تعديل </a>      
                            </div>  
                        </div>';

            })
        ->addColumn('show', function($row) {
                   return '<a href='.url('single-order/'.($row->order_follow?$row->order_follow:$row->id)).' class="btn btn-success btn-sm">عرض </a>';                
            })
        ->rawColumns(['select','process','show'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $get_all_clients = client::all();
         $get_all_categories = category::all();
         $get_all_product = product::all();
         $last_order_added = order::where(['order_follow'=>null])->orderby('created_at','desc')->first();
         
         return view('admin.orders.create')->with(['all_products'=>$get_all_product,'last_order'=>$last_order_added,'all_clients'=>$get_all_clients,'get_all_categories'=>$get_all_categories]);
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
        $final_cost_of_order = 0;
        $payed_value         = 0;

        $this->validate($request,[
            'product_id'=>'required',
            'order_count'=>'required',
            'order_price'=>'required',
            'payment_type'=>'required'
        ]);
        $data = $request->all();
        $request['final_cost']=($request->order_price+($request->order_taxs*$request->order_count))-$request->order_discount;
     
        $last_insert = order::create($request->all());
        $order_id_now = $last_insert->id;
        $last_update = product::where('id',$last_insert->product_id)->decrement('count_piecies',$last_insert->order_count);
        $cloth_styles_id = product::where('id',$last_insert->product_id)->pluck('cloth_styles_id')[0];
        //$last_update = ClothStyles::where('id',$cloth_styles_id)->decrement('count_piecies',$last_insert->order_count);
        $final_cost_of_order = $request['final_cost'];
        if($request->payment_type=='شيك'){
            $count_data_check = count($request->check_owner);
            if( $count_data_check!=0 ){
                for($input_value=0;$input_value<$count_data_check;$input_value++){
                    if(!empty($request->input('check_owner')[$input_value])):
                        $payed_value +=$request->input('check_value')[$input_value]+$request->input('increase_value')[$input_value];
                        $insert_bankcheck = new BankCheck();
                        $insert_bankcheck->bank_checkable_id = $last_insert->client_id;
                        $insert_bankcheck->bank_checkable_type = 'client';
                        $insert_bankcheck->check_date  = $request->input('check_date')[$input_value];
                        $insert_bankcheck->check_value = $request->input('check_value')[$input_value];
                        $insert_bankcheck->increase_value = $request->input('increase_value')[$input_value];
                        $insert_bankcheck->check_owner = $request->input('check_owner')[$input_value];
                        $insert_bankcheck->save();
                    endif;
                }
            }
        }
        if($request->payment_type=='دفعات'){
            if(!empty($request->input('postponed_value') )):
                $payed_value =  $request->input('postponed_value');
                $insert_postponed = new postponed();
                $insert_postponed->client_id = $last_insert->client_id;
                $insert_postponed->posponed_value = $request->input('postponed_value');
                $insert_postponed->save();
            endif;
            
        }

         $check_if_other_order_find = ($request->other_product_id?count($request->other_product_id):0);
         if($check_if_other_order_find!=0){
            for($counter=0;$counter<$check_if_other_order_find;$counter++){
                $final_cost_of_order += ($request->other_order_price[$counter]+$request->other_order_taxs[$counter] - $request->other_order_discount[$counter] );
                $insert_other_order = new order();
                $insert_other_order->client_id   = $last_insert->client_id;
                $insert_other_order->product_id  = $request->other_product_id[$counter];
                $insert_other_order->order_discount  = $request->other_order_discount[$counter];
                $insert_other_order->order_count = $request->other_order_count[$counter];
                $insert_other_order->order_price = $request->other_order_price[$counter];
                $insert_other_order->payment_type= $last_insert->payment_type;
                $insert_other_order->order_taxs  = $request->other_order_taxs[$counter];
                $insert_other_order->final_cost  = ($request->other_order_price[$counter]+$request->other_order_taxs[$counter] - $request->other_order_discount[$counter] );
                $insert_other_order->order_follow= $last_insert->id;
                $insert_other_order->save();    
                $last_update = product::where('id',$request->other_product_id[$counter])->decrement('count_piecies',$request->other_order_count[$counter]);
                $cloth_styles_id = product::where('id',$request->other_product_id[$counter])->pluck('cloth_styles_id')[0];
                //$last_update = ClothStyles::where('id',$cloth_styles_id)->decrement('count_piecies',$request->other_order_count[$counter]);
                    
            }

         }

            // here do any thing 
         if($payed_value>$final_cost_of_order):
            insert_debit_data(($request->client_id?$request->client_id:null),'client','مدين',($payed_value-$final_cost_of_order),$request->payment_type,$last_insert->id);
         endif;

        $last_insert=order::where(['order_follow'=>null])->orderby('created_at','desc')->first();
        return redirect('review-order/'.$order_id_now)->with(['success'=>'تم اضافة الطلب بنجاح','last_order'=>$last_insert]);
        //return back()->with(['success'=>'تم اضافة الطلب بنجاح','last_order'=>$last_insert]);
    }

    function review_order($id){
        $last_order_review = order::where(['id'=>$id])->orWhere('order_follow',$id)->get();
        $last_order_added = order::where(['order_follow'=>null])->orderby('created_at','desc')->first();
        return view('admin.orders.review')->with(['last_order_review'=>$last_order_review,'last_order'=>$last_order_added]);  
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
        $single_order = order::where(['id'=>$id,'order_follow'=>null])->get();
        $other_orders_in_order = order::where(['order_follow'=>$id])->get();
        $client_check = order::where(['id'=>$id,'order_follow'=>null])->count();

        $client_id  = ($client_check?order::where(['id'=>$id,'order_follow'=>null])->pluck('client_id')[0]:null);
        $client_data= ($client_check?client::where('id',$client_id)->get():null);
                     
        return view('admin.orders.single')->with(['other_orders_in_order'=>$other_orders_in_order,'order_id'=>$id,'order_data'=>$single_order,'client_data'=>$client_data]);

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
        return back()->withErrors(['error_delete'=>'لايمكن تعديل  الطلبات']);
        $get_all_clients = client::all();
        $get_all_categories = category::all();
        $get_all_products = product::all();
        $order_product_info = order::with('bank_check')->where('id',$id)->get();
        return view('admin.orders.edite')->with(['get_all_products'=>$get_all_products,'order_product_info'=>$order_product_info,'all_clients'=>$get_all_clients,'get_all_categories'=>$get_all_categories]);

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
         

        $get_last_order_count = order::where('id',$id)->pluck('order_count')[0];
         $this->validate($request,[
            'product_id'=>'required',
            'order_count'=>'required',
            'order_price'=>'required',
            'payment_type'=>'required'
        ]);
        $request['final_cost']=($request->order_price+$request->order_taxs)-$request->order_discount;
        $last_insert = order::where('id',$id)->update($request->only(['product_id','client_id','order_count','order_discount','order_price','order_taxs','payment_type','final_cost']));
        if($get_last_order_count!=$request->order_count){
            $last_update = product::where('id',$id)->increment('count_piecies',$get_last_order_count);
            //$last_update = ClothStyles::where('id',$last_update->cloth_styles_id)->increment('count_piecies',$get_last_order_count);           
        
            $last_update = product::where('id',$last_insert->product_id)->decrement('count_piecies',$last_insert->order_count);
           // $last_update = ClothStyles::where('id',$last_update->cloth_styles_id)->decrement('count_piecies',$last_insert->order_count);           
        }
        if($request->payment_type=='شيك'){
            postponed::where('order_id',$id)->delete();
            $count_data_check = ($request->check_owner?count($request->check_owner):null);
            if( $count_data_check!=0 ){
                for($input_value=0;$input_value<$count_data_check;$input_value++){
                    if(!empty($request->input('check_owner')[$input_value])):
                        if(!empty($request->check_id[$input_value])):
                           BankCheck::where('id',$request->check_id[$input_value])->update(['check_date'=>$request->input('check_date')[$input_value],
                            'check_value'=>$request->input('check_value')[$input_value],'increase_value'=>$request->input('increase_value')[$input_value],
                            'check_owner'=>$request->input('check_owner')[$input_value]]);
                        else:
                            $insert_bankcheck = new BankCheck();
                            $insert_bankcheck->bank_checkable_id = $id;
                            $insert_bankcheck->bank_checkable_type = 'order';
                            $insert_bankcheck->check_date  = $request->input('check_date')[$input_value];
                            $insert_bankcheck->check_value = $request->input('check_value')[$input_value];
                            $insert_bankcheck->increase_value = $request->input('increase_value')[$input_value];
                            $insert_bankcheck->check_owner = $request->input('check_owner')[$input_value];
                            $insert_bankcheck->save();
                        endif;
                    endif;
                }
            }
        }
        elseif($request->payment_type=='دفعات'){
            BankCheck::where(['bank_checkable_id'=>$id,'bank_checkable_type'=>'order'])->delete();
            if(!empty($request->order_id)):
              /*  var_dump($request->input('postponed_finished'));
                exit;*/
               postponed::where('id',$request->order_id)->update(['posponed_value'   =>$request->input('postponed_value')]);
            else:
                $insert_postponed = new postponed();
                $insert_postponed->order_id = $id;
                $insert_postponed->posponed_value = $request->input('postponed_value');
                $insert_postponed->save();
            endif;
           
        }
        else
        {
             BankCheck::where(['bank_checkable_id'=>$id,'bank_checkable_type'=>'order'])->delete();
             postponed::where('order_id',$id)->delete();
       
        }
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
        $get_last_order_count = order::where('id',$id)->pluck('order_count')[0];
        $product_id       = order::where('id',$id)->pluck('product_id')[0];
        $cloth_styles_id  = product::where('id',$product_id)->pluck('cloth_styles_id')[0];
        $last_update = product::where('id',$product_id)->increment('count_piecies',$get_last_order_count);
        //$last_update = ClothStyles::where('id',$cloth_styles_id)->increment('count_piecies',$get_last_order_count);           
        
        $check_any_order_in_order = order::where('order_follow',$id)->pluck('product_id')->toArray();
        $check_any_id_in_order    = order::where('order_follow',$id)->pluck('id')->toArray();
        if($check_any_order_in_order){
            for($counter=0;$counter<count($check_any_order_in_order);$counter++){
                $get_last_order_count = order::where('id',$check_any_id_in_order[$counter])->pluck('order_count')[0];
                $last_update = product::where('id',$check_any_order_in_order[$counter])->increment('count_piecies',$get_last_order_count);
                $cloth_styles_id  = product::where('id',$check_any_order_in_order[$counter])->pluck('cloth_styles_id')[0];
               // $last_update = ClothStyles::where('id',$cloth_styles_id)->increment('count_piecies',$get_last_order_count);           
          
            }
        }
        order::where('id',$id)->delete();
      //  BankCheck::where(['bank_checkable_id'=>$id,'bank_checkable_type'=>'order'])->delete();
      //  postponed::where('order_id',$id)->delete();
        if($type_return=='single'){
            return redirect('show-orders');
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
        /*if(!$request->input('select')){
          return back();
        }*/
        
   /*     $get_last_order_count = order::where('id',$id)->pluck('order_count')[0];
        $last_update = product::where('id',$id)->increment('count_piecies',$get_last_order_count);
        $last_update = ClothStyles::where('id',$last_update->cloth_styles_id)->increment('count_piecies',$get_last_order_count);           
        */

   /*     order::whereIn('id',$request->input('select'))->delete();
        BankCheck::whereIn('bank_checkable_id',$request->input('select'))->where(['bank_checkable_type'=>'order'])->delete();
        postponed::whereIn('order_id',$request->input('select'))->delete();
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);*/
         order::whereIn('id',$request->input('select'))->delete();
        return back()->withErrors(['error_delete'=>'تم حذف الطلبات بنجاح']);
    }
    
    /**
     * Remove All resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncated(){
         /*
        $get_last_order_count = order::where('id',$id)->pluck('order_count')[0];
        $last_update = product::where('id',$id)->increment('count_piecies',$get_last_order_count);
        $last_update = ClothStyles::where('id',$last_update->cloth_styles_id)->increment('count_piecies',$get_last_order_count);           
        */
    /*    order::truncate();
        BankCheck::where(['bank_checkable_type'=>'order'])->delete();
        postponed::truncate();
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);*/
        order::truncate();
        return back()->with(['success'=>'تم حذف الطلبية بنجاح']);
    }
}
