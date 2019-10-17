<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table="sales";
    protected $primaryKey="id";

    public function account(){
        return $this->belongsTo('App\Accounts','user_id','id');
    }
    public function item(){
        return $this->belongsTo('App\Inventory','product_id','id');
    }
    
}
