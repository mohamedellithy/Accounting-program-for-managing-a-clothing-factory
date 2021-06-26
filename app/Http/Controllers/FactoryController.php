<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use App\setting;
use App\withdraw;
use App\MerchantPayment;
use App\orderClothes;
use App\ClothStyles;
use App\SupplierPayment;
use App\product;
use App\debit;
use App\ClientPayment;
use App\order;
use App\expances;
use App\reactionist;
use DB;
class FactoryController extends Controller
{
    //
    public function index(){
        $get_all_partners = Partner::all();
        $capital          = setting::where('setting','Capital')->select('value')->first();
        $Context          = [
            'Capital'                    => $capital,
            'all_partners'               => $get_all_partners,
            'net_profit'                 => ProfitController::Caluculate_net_profit(),
            'out_goings'                 => ProfitController::Calculate_outgoings(),
            'net_profit_after_withdraw'  => ProfitController::Calculate_Profit_After_Withdraw(),
            'Factory_percent'            => ProfitController::Calculate_Factory_Percent(),
            'Factory_Profit'             => ProfitController::Calculate_Factory_Profit(),
            'Last_Profit_Capital'        => ProfitController::Calculate_Last_Profit_Capital(),
        ];
        return view('admin.capital.index')->with($Context);
    }

    public function CreateCapital(Request $request){
        setting::where('setting','Capital')->Update([
            'setting' => 'Capital',
            'value'   => $request->capital_value,
        ]);
        return back();
    }

    public function moneysafe(){
        $Context = [
            'get_capital_factory_before_withdraw' => self::get_capital_factory_before_withdraw(),
            'partners_capitals_after_withdraw'    => self::partners_capitals_after_withdraw(),
            'get_outgoings'                       => self::get_outgoings(),
            'get_outgoings_payed'                 => self::get_outgoings_payed(),
            'get_ClothStyles_in_factory'          => self::get_ClothStyles_in_factory(),
            'get_ClothStyles_for_suppliers'       => self::get_ClothStyles_for_suppliers(),
            'get_ClothStyles_for_suppliers_payed' => self::get_ClothStyles_for_suppliers_payed(),
            'get_product_purchased'               => self::get_product_purchased(),
            'get_debit_on_merchant'               => self::debits('merchant','دائن'),
            'get_debit_on_merchant_paid'          => self::debits_payed('merchant','دائن'),
            'get_debit_on_supplier'               => self::debits('supplier','دائن'),
            'get_debit_on_supplier_paid'          => self::debits_payed('supplier','دائن'),
            'get_debit_on_client'                 => self::debits('client','دائن'),
            'get_debit_on_client_paid'            => self::debits_payed('client','دائن'),
            'get_debit_for_merchant'              => self::debits('merchant','مدين'),
            'get_debit_for_merchant_paid'         => self::debits_payed('merchant','مدين'),
            'get_debit_for_supplier'              => self::debits('supplier','مدين'),
            'get_debit_for_supplier_paid'         => self::debits_payed('supplier','مدين'),
            'get_debit_for_client'                => self::debits('client','مدين'),
            'get_debit_for_client_paid'           => self::debits_payed('client','مدين'),
            'all_saling'                          => self::all_saling(),
            'get_sales_payed'                     => self::get_sales_payed(),
            'partner_withdraw_profit_all'         => self::partner_withdraw_profit_all(),
            'profit_all_withdraws'                => self::profit_all_withdraws(),
            'get_all_expances'                    => self::get_all_expances(),
            'all_reactionist'                    => self::get_all_reactionist(),
        ];
        return view('admin.sales.money-safe')->with($Context);
    }

    static function get_capital_factory_before_withdraw(){
        $all_withdraws_in_capital_factory  = withdraw::where('created_at','>=',Fiscal_Year())
           ->where(['type'=>1,'partner_id'=>0])
           ->where('created_at','>=',Fiscal_Year())
           ->sum('value');
        return FactoryCapital() + $all_withdraws_in_capital_factory;
    }

    static function partners_capitals_after_withdraw(){
        $partners_capitals_after_withdraw  = withdraw::where('created_at','>=',Fiscal_Year())
        ->where('partner_id','!=',0)
        ->where('created_at','>=',Fiscal_Year())
        ->sum('value');
        return PartnersCapital() - $partners_capitals_after_withdraw;
    }

    static function get_outgoings($date_from = null,$date_to = null){
        if( ( $date_from!=null ) && ( $date_to!=null ) ){
            return $get_outgoings_order_price    = orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_price');
        }

        return $get_outgoings_order_price = orderClothes::where('created_at','>=',Fiscal_Year())->sum('order_price');
    }

    static function get_outgoings_payed($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            $Payments    = MerchantPayment::whereBetween('created_at',array($date_from,$date_to))->sum('value');
            $order_cache = orderClothes::whereBetween('created_at',array($date_from,$date_to))
                           ->where('payment_type','نقدى')
                           ->sum('order_price');
            return $Payments + $order_cache;
        }

        $Payments    = MerchantPayment::where('created_at','>=',Fiscal_Year())->sum('value');
        $order_cache = orderClothes::where('created_at','>=',Fiscal_Year())
                           ->where('payment_type','نقدى')
                           ->sum('order_price');
        return $Payments + $order_cache;
    }

    static function get_ClothStyles_in_factory($date_from = null,$date_to = null){
        if(($date_from!=null)&& ($date_to!=null)){
            $get_factory_expances = ClothStyles::whereBetween('created_at',array($date_from,$date_to))->where('supplier_id',null)->select( DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];
        }
        $get_factory_expances     = ClothStyles::where('created_at','>=',Fiscal_Year())->where('supplier_id',null)->select(DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];

        return $get_factory_expances;
    }

    static function get_ClothStyles_for_suppliers($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_supplier_payed = ClothStyles::whereBetween('created_at',array($date_from,$date_to))->where('supplier_id','!=',null)->select( DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];
        }
        return $get_supplier_payed     = ClothStyles::where('created_at','>=',Fiscal_Year())->where('supplier_id','!=',null)->select(DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];
    }

    static function get_ClothStyles_for_suppliers_payed($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_supplier_payed = SupplierPayment::whereBetween('created_at',array($date_from,$date_to))->sum('value');
        }
        return $get_supplier_payed     = SupplierPayment::where('created_at','>=',Fiscal_Year())->sum('value');
    }

    static  function get_product_purchased($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $all_product_cost     = product::whereBetween('created_at',array($date_from,$date_to))->where('cloth_styles_id',null)->sum('full_price');
        }

        return $all_product_cost         = product::where('created_at','>=',Fiscal_Year())->where('cloth_styles_id',null)->sum('full_price');
    }

    static function debits($type_debit,$debit_sect,$date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_payed_check = debit::whereBetween('created_at',array($date_from,$date_to))
            ->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])
            ->sum(DB::raw('debit_value - debit_paid'));
        }
        return $get_payed_check     = debit::where('created_at','>=',Fiscal_Year())
                ->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])
                ->sum(DB::raw('debit_value - debit_paid'));
    }

    static function debits_payed($type_debit,$debit_sect,$date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_payed_check = debit::whereBetween('created_at',array($date_from,$date_to))
            ->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])
            ->sum(DB::raw('debit_paid'));
        }
        return $get_payed_check     = debit::where('created_at','>=',Fiscal_Year())
                ->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])
                ->sum(DB::raw('debit_paid'));
    }

    static function all_saling($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
          return $get_all_sale = order::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
        }

        return $get_all_sale   = order::where('created_at','>=',Fiscal_Year())->sum('final_cost');
    }

    static function get_sales_payed($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
          $order_cache = order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','نقدى')->sum('final_cost');
          return $order_cache + self::all_client_payments();
        }

        $order_cache   = order::where('created_at','>=',Fiscal_Year())->where('payment_type','نقدى')->sum('final_cost');
         return $order_cache + self::all_client_payments();
    }

    static function all_client_payments($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_client_payed = ClientPayment::whereBetween('created_at',array($date_from,$date_to))->sum('value');
        }
        return $get_client_payed     = ClientPayment::where('created_at','>=',Fiscal_Year())->sum('value');

    }

    static function partner_withdraw_profit_all($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_client_payed = withdraw::whereBetween('created_at',array($date_from,$date_to))
            ->where('partner_id','!=',0)->where('type',0)->sum('value');
        }
         return $get_client_payed = withdraw::where('created_at','>=',Fiscal_Year())
            ->where('partner_id','!=',0)->where('type',0)->sum('value');

    }

    static function profit_all_withdraws($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_client_payed = withdraw::whereBetween('created_at',array($date_from,$date_to))
            ->where('type',0)->sum('value');
        }
         return $get_client_payed = withdraw::where('created_at','>=',Fiscal_Year())
            ->where('type',0)->sum('value');
    }

    static function get_all_expances($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_expances_price_cache     = expances::whereBetween('created_at',array($date_from,$date_to))->sum('expances_value');
        }

        return $get_expances_price_cache         = expances::where('created_at','>=',Fiscal_Year())->sum('expances_value');
    }

    static function get_all_reactionist($date_from=null,$date_to=null){
        if(($date_from!=null)&& ($date_to!=null)){
            return $get_reactionist     = reactionist::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
        }

        return $get_reactionist          = reactionist::where('created_at','>=',Fiscal_Year())->sum('final_cost');

    }



}
