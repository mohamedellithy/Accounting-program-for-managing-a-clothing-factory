<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\order;
use Carbon\Carbon;
use App\expances;
use App\category;
use App\product;
use DB;
class sales extends Controller
{
    public $search_data =array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all_data =array();
        $last_value=0;
        $get_all_category = category::all();
        $all_sales = DB::table('orders')->where('created_at','>=',Fiscal_Year)->select('created_at','id','product_id','final_cost','order_price')->get();
        $type_filter=2;
        if(!empty($all_sales)):
            foreach ($all_sales as $key => $value):
                if($type_filter===1):
                   $date_format = date('Y-m-d',strtotime($value->created_at));
                elseif($type_filter===2):
                    $date_format = date('Y-m',strtotime($value->created_at));
                 else:
                    $date_format = date('Y',strtotime($value->created_at));
                endif;
                $all_data[$date_format]['sale']  =(!empty($all_data[$date_format]['sale'])?$all_data[$date_format]['sale']:0) + $value->final_cost;
                $all_data[$date_format]['orders']=(!empty($all_data[$date_format]['orders'])?$all_data[$date_format]['orders']:0)+1;
                $all_data[$date_format]['profit']=(!empty($all_data[$date_format]['profit'])?$all_data[$date_format]['profit']:0) + ($value->final_cost-$value->order_price);

            endforeach;
        endif;
        $search_data = $all_data;

        // $search_data= self::filter_search_data($all_sales,1);
        return view('admin.sales.index')->with(['report_data'=>$search_data,'get_all_category'=>$get_all_category]);

    }

    function get_report_sales(Request $request){
        $type_filter=$request->type_filter;
        $all_data =array();
        $last_value=0;
        $get_all_category = category::all();
        if(!empty($request->category_id)):
           $all_products_id = product::where('category_id',$request->category_id)->pluck('id')->toArray();
           $all_sales = DB::table('orders')->where('created_at','<=',$request->from?date('Y-m-d',strtotime($request->from)):Fiscal_Year)->where('created_at','>=',$request->to?date('Y-m-d',strtotime($request->to)):date('Y-m-d'))->whereIn('product_id',$all_products_id)->select('created_at','id','product_id','final_cost','order_price')->get();
        else:
           $all_sales = DB::table('orders')->where('created_at','<=',$request->from?date('Y-m-d',strtotime($request->from)):Fiscal_Year)->where('created_at','>=',$request->to?date('Y-m-d',strtotime($request->to)):date('Y-m-d'))->select('created_at','id','product_id','final_cost','order_price')->get();
        endif;
        if(!empty($all_sales)):
            foreach ($all_sales as $key => $value):
                if($request->type_filter==1):
                   $date_format = date('Y-m-d',strtotime($value->created_at));
                elseif($request->type_filter==2):
                    $date_format = date('Y-m',strtotime($value->created_at));
                 else:
                    $date_format = date('Y',strtotime($value->created_at));
                endif;
                $all_data[$date_format]['sale']  =(!empty($all_data[$date_format]['sale'])?$all_data[$date_format]['sale']:0) + $value->final_cost;
                $all_data[$date_format]['orders']=(!empty($all_data[$date_format]['orders'])?$all_data[$date_format]['orders']:0)+1;
                $all_data[$date_format]['profit']=(!empty($all_data[$date_format]['profit'])?$all_data[$date_format]['profit']:0) + ($value->final_cost-$value->order_price);

            endforeach;
        endif;
        $search_data = $all_data;
        return view('admin.sales.index')->with(['report_data'=>$search_data,'get_all_category'=>$get_all_category]);

    }

    function moneysafe(){
          return view('admin.sales.money-safe');
    }


}
