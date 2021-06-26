<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\partner;
use App\order;
use App\orderClothes;
use App\Profit;
use DB;
use App\reactionist;
use Carbon\Carbon;
use App\setting;
class ProfitController extends Controller
{
    static function Transaction_Profit_Partners(){
        $partners = partner::where('partner_status',0)->get();
        $partners->each(function($partner){
            if($partner->profit_from_percent == 0) return;
            Profit::create([
                'partner_id' => $partner->id,
                'value'      => $partner->profit_from_percent
            ]);
            $partner->created_at  = Carbon::now()->toDateTimeString();
            $partner->save();
        });
    }

    static function Transaction_Profit_Capital(){
        $Factory_Profit = ProfitController::Calculate_Factory_Profit();
        if($Factory_Profit == 0) return;
        Profit::create([
            'partner_id' => 0,
            'value'      => $Factory_Profit
        ]);
        setting::where('setting','Capital')->update([
            'created_at'=>Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     *  here get date of created capital
     **/
    static function Factory_Capital_Date(){
        $date = setting::where(['setting'=>'Capital'])->select('created_at')->first();
        return  $date ->created_at;
    }


    /**
     * calaculate Net profit
     **/
    static function Caluculate_net_profit($date_from=null,$date_to=null){
        $get_outgoings_order_price = order::where('created_at','>',self::Factory_Capital_Date())
            ->sum(DB::raw('final_cost - order_price'));

        return $get_outgoings_order_price - self::Calculate_reactionist();
    }

    /**
     * calaculate out_goings
     **/
    static function Calculate_outgoings($date_from = null,$date_to = null){
        if( ( $date_from!=null ) && ( $date_to!=null ) ){
            return orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_price');
        }

        return orderClothes::where('created_at','>=',Fiscal_Year())->sum('order_price');
    }

    /**
     * calaculate reactionist
     **/
    static function Calculate_reactionist($date_from = null,$date_to = null){
        if( ( $date_from!=null ) && ( $date_to!=null ) ){
            return reactionist::where('created_at','>',self::Factory_Capital_Date())
               ->sum(DB::raw('profit_order'));
        }

        return reactionist::where('created_at','>=',Fiscal_Year())
                 ->where('created_at','>',self::Factory_Capital_Date())
                 ->sum(DB::raw('profit_order'));
    }

    /**
     * calaculate Profit After Withdraw
     **/
    static function Calculate_Profit_After_Withdraw($date_from=null,$date_to=null){
        $NetProfit = self::Caluculate_net_profit($date_from,$date_to);
        if($NetProfit != null){
            return $NetProfit - factory_prodfit_withdraw() - partner_withdraw_profit_all();
        }

        return 0;
    }

    /**
     * calaculate Factory Percent
     **/
    static function Calculate_Factory_Percent($date_from=null,$date_to=null){
        if( FactoryCapital() == 0 ) return 0;
        $percent = (FactoryCapital() / ToatalCapital()) * 100;
        return round($percent,1);
    }

    /**
     * calaculate Factory Profit
     **/
    static function Calculate_Factory_Profit($date_from=null,$date_to=null){
        $Factory_Profit = (self::Calculate_Factory_Percent() * self::Caluculate_net_profit() ) / 100;
        return round($Factory_Profit,1);
    }

    static function Calculate_Last_Profit_Capital(){
        $profits = Profit::where('partner_id',0)->sum('value');
        return $profits;
    }

}
