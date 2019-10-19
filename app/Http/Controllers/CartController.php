<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartRes;
use App\Cart;
use App\Inventory;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;
use Illuminate\Session\SessionManager;
use App\Settings;

class CartController extends Controller
{
    public function mycart(){
        $id=session('id');
        //$cart=Cart::where('user_id','=',$id)->with('product')->get();
        $cart=Cart::where('user_id','=',$id)->with('product')->get();
        $sale=Settings::find(1)->globalSale;
        $tax=Settings::find(1)->tax;
        return response()->json(['cart'=>$cart,'tax'=>$tax,'sale'=>$sale]);
    }
    public function addtocart(request $request){
        $err1=null;
        $err2=null;
        $cart=null;
        $usr=session('id');
        $id=$request->input('id');
        $q=$request->input('quant');
        if(Cart::where([['user_id','=',$usr],['product_id','',$id]])->first()){
            $err2="You already have this item in your cart";
        }else{
        if($inv=Inventory::find($id)->quantity>=$q){
            //make new
            $cart=new Cart;
            $cart->user_id=$usr;
            $cart->product_id=$id;
            $cart->quantity=$q;
            $cart->created_at=NOW();
            $cart->updated_at=NOW();
            $cart->save();
            //$inv->quantity=$inv->quantity-$q;  ONLY ADDING TO CART, NOT CHECKING OUT, SO NO NEED TO TRUNC DATA
           // $inv->save();

        } else{
            $err1="Sorry, the product quantity has changed while processing your action, please try again";
        };
    };
        return response()->json(['err1'=>$err1,'err2'=>$err2]);
    }
    public function plus(request $request){
        $cid=$request->input('itemid');
        $q=$request->input('quant');   
        $cart=Cart::find($cid);
        $cart->quantity=$q;
        $cart->save();
        return response()->json(['msg'=>'Successfully updated']);
    }
    public function minus(request $request){
        $cid=$request->input('itemid');
        $q=$request->input('quant'); 
        if($q>=1){    //anti js-hackers - even if the client passes a 0 or a negative value thru the api, update wont fire
        $cart=Cart::find($cid);
        $cart->quantity=$q;
        $cart->save();
        };
        return response()->json(['msg'=>'Successfully updated']);
    }
    public function delete($id){
        Cart::find($id)->delete();
        return response()->json(['msg'=>'Successfully deleted lmao']);
    }
}
