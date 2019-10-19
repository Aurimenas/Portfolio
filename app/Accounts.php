<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;


class Accounts extends Model
{
    protected $table="accounts";
    protected $primaryKey="id";
    protected $fillable=[
        "usn","group","pwd","created_at","updated_at"
    ];
    public function setPwdAttribute($value){
        $this->attributes['pwd']=Crypt::encryptString($value);
    }
    public function sale(){
        return $this->hasMany('App\Sales','id','user_id');
    }
}
