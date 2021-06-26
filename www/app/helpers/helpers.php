<?php
##########################################################################################################
#########################################################################################################
function Fiscal_Year(){
    $Fiscal_Year = App\setting::where('setting','Fiscal_Year')
                  ->select('value')->first();
    return $Fiscal_Year->value;
}
######################
function FactoryCapital(){
    $capital  = App\setting::where('setting','Capital')
                  ->select('value')->first();
    return $capital->value ?? 0;
}
######################
function PartnersCapital(){
    $partnersCapital = App\Partner::where('created_at','>=',Fiscal_Year())
    ->where('partner_status',0)
    ->sum('capital');
    return $partnersCapital;
}
######################
function ToatalCapital(){
    $total =  PartnersCapital() + FactoryCapital();
    return $total;
}
######################
function Net_profit($date_from=null,$date_to=null){
    if( ( $date_from!=null ) && ( $date_to!=null ) ){
        $get_outgoings_order_price = App\order::whereBetween('created_at',array($date_from,$date_to))
            ->sum(DB::raw('final_cost - order_price'));
    }
    else{
        $get_outgoings_order_price = App\order::where('created_at','>=',Fiscal_Year())
            ->sum(DB::raw('final_cost - order_price'));
    }

    return $get_outgoings_order_price - Calculate_reactionist();
}
######################
function Calculate_reactionist($date_from = null,$date_to = null){
    if( ( $date_from!=null ) && ( $date_to!=null ) ){
        return App\reactionist::whereBetween('created_at',array($date_from,$date_to))
            ->sum(DB::raw('profit_order'));
    }

    return App\reactionist::where('created_at','>=',Fiscal_Year())->sum(DB::raw('profit_order'));
}
######################
function Calculate_Profit_After_Withdraw($date_from=null,$date_to=null){
    $NetProfit = Net_profit($date_from,$date_to);
    if($NetProfit != null){
        return $NetProfit  - partner_withdraw_profit_all();
    }

    return 0;
}
#########################
function partner_withdraw_profit_all(){
   $previouse_withdraw  = App\withdraw::where('type','!=',1)->sum('value');
   return $previouse_withdraw;
}
#########################
function factory_prodfit_withdraw(){
   $all_withdraws  = App\withdraw::where('partner_id',0)->where('created_at','>=',Fiscal_Year())->sum('value');
   return $all_withdraws;
}

