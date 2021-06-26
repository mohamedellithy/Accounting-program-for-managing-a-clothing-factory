<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Partner extends Model
{
    //

    protected $table = "partners";

    protected $fillable = [
         'partner_name','partner_phone','capital','partner_percent','partner_ended_at','partner_status',
    ];

    public function withdraw(){
        return $this->hasMany('App\withdraw','partner_id','id');
    }

    public function profit(){
        return $this->hasMany('App\Profit','partner_id','id');
    }

    function getLastProfitsAttribute(){
        #last_profits
        return Profit::where('partner_id',$this->id)->sum('value');
    }



    function getTotalCapitalAttribute(){
        # total_capital
       $partnersCapital = $this->where('created_at','>=',Fiscal_Year())
       ->where('created_at','>',$this->created_at)->sum('capital');
       return $partnersCapital + FactoryCapital();
    }

    public function getPercentAttribute(){
        # percent attribute
        if( $this->partner_status == 1) return 0;
        $percent = ( $this->capital / ToatalCapital() ) * 100;
        return round($percent,1);
    }

    public function getCalProfitAttribute(){
        # cal_profit attribute
        $profit =  order::where('created_at','>',$this->created_at)
                   ->sum(DB::raw('final_cost - order_price'));
        return $profit - $this->profit_from_reactionist;
    }

    function getProfitFromReactionistAttribute(){
        # profit_from_reactionist
        return reactionist::where('created_at','>',$this->created_at)
        ->sum(DB::raw('profit_order'));
    }

    public function getProfitFromPercentAttribute(){
        # profit_from_percent attribute
        $total_profit = ( $this->percent * $this->cal_profit ) / 100;
        return round($total_profit,1);
    }

     function getPartnerCacheProfitsAttribute(){
        #partner_cache_profits
        return $this->last_profits + $this->profit_from_percent - $this->withdraw()->sum('value');
    }

}
