<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class withdraw extends Model
{
    //

    protected $fillable = [
         'partner_id','value','type'
    ];


    public function partner(){
        return $this->belongsTo('App\partner','partner_id','id');
    }

    public function profit(){
        return $this->hasOne('App\withdraw','withdraw_id','id');
    }

    public function getRestOfPartnerCapitalAttribute(){
        #rest_of_partner_capital
        return $this->partner->capital - $this->sum('value');
    }

    public function getTypeOfWithdrawAttribute(){
        #Type_of_withdraw
        if($this->type == 0):
            return 'سحب ارباح مبلغ :'.$this->value;
        elseif($this->type == 1):
            return 'سحب من راس المال';
        endif;

    }
}
