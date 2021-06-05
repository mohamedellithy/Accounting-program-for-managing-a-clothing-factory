<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    //
    protected $fillable=[
      'supplier_name','supplier_phone',
    ];

    public function clothes_styles(){
        return $this->hasMany('App\ClothStyles','supplier_id','id');
    }


    public function debit()
    {
        return $this->morphMany(debit::class, 'debitable');
    }
}
