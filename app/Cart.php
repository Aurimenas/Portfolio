<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Inventory;

class Cart extends Model
{
    protected $table="cart";
    protected $primaryKey="id";
    //protected $foreignKey="product_id";

    public function product(){
       return $this->belongsTo('App\Inventory','product_id','id');
    }
}
