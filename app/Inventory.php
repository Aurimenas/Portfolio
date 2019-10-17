<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use App\Cart;

class Inventory extends Model
{
    protected $table="inventory";
    protected $primaryKey="id";
    public function cart(){
       return $this->hasMany('App\Cart','id','product_id');
    }
    public function sale(){
        return $this->hasMany('App\Sales','id','product_id'); //foreign key (AS ON THE APP\SALES), local key (AS ON THE APP\SALES!)
    }
}
