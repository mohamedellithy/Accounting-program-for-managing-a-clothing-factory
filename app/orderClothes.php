<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderClothes extends Model
{
    //
    protected $fillable = [
        'merchant_id','invoice_no','category_id','order_size_type','order_size','order_price','order_discount','payment_type','price_one_piecies','order_follow','order_finished',
    ];


    public function bank_check()
    {
        return $this->morphMany(BankCheck::class, 'bank_checkable');
    }

    public function merchant(){
        return $this->belongsTo('App\merchant','merchant_id','id');
    }

    public function category_name(){
        return $this->belongsTo('App\category','category_id','id');
    }

    public function postponeds_money(){
        return $this->hasMany('App\postponed_orderClothes','orderClothes_id','id');
    }

    public function getOrdersAttachedAttribute(){
        # orders_attached
        return $this->where('order_follow',$this->id)->get();
    }

    public function getOrdersInInvoicesAttribute(){
        # orders_in_invoices
        return $this->where('id',$this->id)->Orwhere('order_follow',$this->id)->get();
    }

    public function getTotalInvoiceAttribute(){
        # total_invoice
        return  $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->sum('order_price');
    }

    public function getAttachedOrdersCategoryAttribute(){
       # attached_orders_category
       $category_IDS  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->pluck('category_id')->toArray();
       return implode(' - ',Category::whereIn('id',$category_IDS)->pluck('category')->toArray());
    }

    public function getAttachedOrdersDiscountsAttribute(){
       # attached_orders_discounts
       $discounts  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->pluck('order_discount')->toArray();
       return implode('% - ',$discounts);
    }

    public function getAttachedOrdersSizeAttribute(){
        # attached_orders_size
        $sizes  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->pluck('order_size')->toArray();
        return implode(' - ',$sizes);
    }

    public function getOrderNotFinishedAttribute(){
        # order_not_finished
        return $this->where('id',$this->id)->WhereNull('order_finished')->get();
    }

    # public function getOrderFinishedAttribute(){
    #     #order_finished
    #      return $this->where('id',$this->id)->Where('order_finished','!=',Null)->first();
    # }

    # public function ScopeFinished($query){
    #     #Finished
    #     return $query->where('order_finished',1);
    # }
    # public function ScopeCache($query){
    #     #Cache
    #    return $query->where('payment_type','نقدى');
    # }
    # public function ScopeCheque($query){
    #     #Cheque
    #     return $query->where('payment_type','شيك');
    # }


}
