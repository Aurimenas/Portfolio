<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\Inventory;
use App\Accounts;
use App\Http\Resources\SalesRes;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;
use Illuminate\Session\SessionManager;

class SalesController extends Controller
{
    public function mine(){
        $id=session('id');
        $sales=Sales::where('user_id','=',$id)->with('item')->get();
        //return response()->json(['items'=>$sales]);
        return SalesRes::collection($sales);
    }

    public function give(){
        //returns the entire list of sales ordred by new
        $sales=Sales::orderBy('created_at','DESC')->with('item')->with('account')->get();
        return SalesRes::collection($sales);
    }

    public function stats(){
        $acc=Accounts::find(session('id'));
       if($acc->group==="Admin"){
      $revyear=Sales::where([['status','=','1'],['created_at','>',DATE('Y').'-1-1']])->sum('total');
       $revtot=Sales::where('status','=','1')->sum('total');
        $salesyear=Sales::where([['status','=','1'],['created_at','>',DATE('Y').'-1-1']])->count();
        $salestot=Sales::where('status','=','1')->count();
        //array of 12 elements
      
        $monthcount=array();
        for($month=0;$month<12;$month++){
            $monthcount[$month]=Sales::where([['status','=','1'],['created_at','>=',DATE('Y').'-'.($month+1).'-01'],['created_at','<',DATE('Y').'-'.($month+2).'-01']])->count();
        };
   
        return response()->json(['revyear'=>$revyear,'revtot'=>$revtot,'salesyear'=>$salesyear,'salestot'=>$salestot,'month'=>$monthcount]);
        }else{
            return redirect(url('/'));
        };
    }
 
}
