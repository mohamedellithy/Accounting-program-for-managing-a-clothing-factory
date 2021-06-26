<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //

    protected $fillable = [
         'invoice_no','client_id','product_id','order_discount','order_taxs','order_price','payment_type','order_count','final_cost','order_follow',
    ];

    public function product(){
        return $this->belongsTo('App\product','product_id','id');
    }

     public function client(){
        return $this->belongsTo('App\client','client_id','id');
    }

    public function postponeds_money(){
        return $this->hasMany('App\postponed','order_id','id');
    }

    public function reactionist(){
        return $this->hasMany('App\reactionist','order_id','id');
    }

    public function getAttachedOrdersAttribute(){
        # attached_orders
       return $this->where('order_follow',$this->id)->get();
    }

    public function getParentOrderAttribute(){
        # parent_order
        $order_id = $this->pluck('order_follow')->toArray();
        if($order_id[0] != null)
           return $this->whereIN('id',$order_id)->whereNULL('order_follow')->first();

        return $this;
    }

    public function getTotalInvoicesAttribute(){
        # total_invoices
       return $this->where('id',$this->id)->Orwhere('order_follow',$this->id)->sum('final_cost');
    }

    public function getInvoicesProductsNameAttribute(){
       # invoices_products_name
        $orders  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->get();
        $Product_Name  = $orders->map(function($order,$key){
          return $order->product->name_product;
        })->all();

        return $Product_Name;
    }

    public function getInvoicesCategoriesNameAttribute(){
       # invoices_categories_name
        $orders  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->get();
        $Category_Name  = $orders->map(function($order,$key){
          return $order->product->category->category;
        })->all();

        return $Category_Name;
    }

     public function getInvoicesQuantityAttribute(){
       # invoices_quantity
        $Qty  = $this->where('id',$this->id)->OrWhere('order_follow',$this->id)->pluck('order_count')->toArray();
        return $Qty;
    }

    public function getInvoicesItemsAttribute(){
        # invoices_items
        return $this->where('id',$this->id)->Orwhere('order_follow',$this->id)->get();
    }


}
