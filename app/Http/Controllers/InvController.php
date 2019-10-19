<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Inventory;
use App\Cart;
use App\Http\Resources\InvRes;
use Image;
use App\Settings;

class InvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function full(){
        $inv=Inventory::where('active','=','1')->get();
        return InvRes::collection($inv);
     }
    public function give(request $request)
    {
        //full list of all the items availabl in the store
        $cat=$request->input('cat');
        $debug=$cat;
        if($cat==='child'){
            $inv=Inventory::where([['active','=','1'],['children','=','1']])->paginate(6);
            
        }elseif($cat==='Mens'){
            $inv=Inventory::where([['active','=','1'],['mens','=','1']])->paginate(6);
        }elseif($cat==="Womens"){
            $inv=Inventory::where([['active','=','1'],['womens','=','1']])->paginate(6);
        }else{
            $inv=Inventory::where('active','=','1')->paginate(6);
        };
        
        //return InvRes::collection($inv);
        $tax=Settings::find(1)->tax;
        $sale=Settings::find(1)->globalSale;
        return response()->json(['data'=>$inv,'tax'=>$tax,'sale'=>$sale,'debug'=>$debug]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function One(request $request, $id)
    {
        //returns a single item so that an item's page could be built using this data
        $inv=Inventory::find($id);
        $err3=null;
        //check if person has it in cart already, if so, the "add to cart button will be disabled"
        if(Cart::where([['user_id','=',session('id')],['product_id','=',$id]])->first()){
            $err3="Sorry, you already have it in your cart";
        };
        $tax=Settings::find(1)->tax;
        $sale=Settings::find(1)->globalSale;
        return response()->json(['inv'=>$inv,'err3'=>$err3,'tax'=>$tax,'sale'=>$sale]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new(request $request){
        $price=$request->input('price');
        $name=$request->input('name');
        $men=$request->input('mens');
        $women=$request->input('womens');
        $child=$request->input('children');
        $desc=$request->input('desc');
        $quant=$request->input('quant');
        $err1=null;//empty name
        $err2=null;//empty price or negative
        $err3=null;//empty desc
        $err4=null; //empty initial quantity
        $errimg=null;
        $err5=null; //success
        //$imageName = time().'.'.$request->image->getClientOriginalExtension();
        //$request->image->move(public_path('storage/img/'), $imageName);
        if($request->input('img')===null){
            $errimg="No file selected";
        }else{
            $explode=explode(',',$request->input('img'));
            if(!strpos($explode[0],'image')){
                $errimg="This type of file is not accepted";
            };
            if(strpos($explode[0],'jpeg')){
                $ext='jpg';
            }else{
            $ext='png';
            };
            $decoded=base64_decode($explode[1]);
           
            $filename=rand().time().'.'.$ext;
            $path=public_path().'/storage/img/'.$filename;
            file_put_contents($path,$decoded);
            
        };
        if(empty($name)){
            $err1="Your product name is left empty";
        
        };
        if(empty($price) or $price<0){
            $err2="Your specified price input is not valid";
        };
        if(empty($desc)){
            $err3="Please describe your product";
        };
        if(empty($quant) or $quant<0){
            $err4="Your specified initial quantity is not valid";
        };
        if($err1===null && $err2===null && $err3===null && $err4===null  && $errimg===null){
            $err5="success";
            $new=new Inventory;
            $new->name=$name;
            $new->mens=$men;
            $new->womens=$women;
            $new->children=$child;
            $new->quantity=$quant; 
            $new->picture=$filename;
            $new->desc=$desc;
            $new->price=$price;
            $new->active="1";
           // $new->created_at=NOW();
           // $new->updated_at=NOW();
            $new->save();
            return response()->json(['item'=>$new,'err5'=>$err5]);
        };
        return response()->json(['err1'=>$err1,'err2'=>$err2,'err3'=>$err3,'err4'=>$err4,'err5'=>$err5,'errimg'=>$errimg]);
    }

   
    public function update(Request $request)
    {
        //PRODUCT QUANTITY EDITING (+NEW SHIPMENT ARRIVED ETC) DONE SEPERATELY TO AVOID OBSOLETE REQUEST DATA UPDATING BY USING INCREASING INSTEAD OF REPLACING Quant
        $name=$request->input('name');
        $desc=$request->input('desc');
        $mens=$request->input('mens');
        $womens=$request->input('womens');
        $children=$request->input('children');
        $img=$request->input('img');
        $price=$request->input('price');
        $itemid=$request->input('itemid');
        $err1=null;
        $err2=null;
        $err3=null;
        $err4=null;
        $err5=null;
        if(strlen($name)<5 OR Inventory::where([['id','!=',$itemid],['name','=',$name]])->first()){
            $err1="Product name is too short or already in use";
        };
        if(strlen($desc)<5){
            $err2="Please describe the product";
        };
        if(strlen($price)<5 OR $price<0){
            $err4="Please specify a valid price";
        };
        if($err1===null && $err2===null && $err4===null){
        $itemas=Inventory::find($itemid);
        if($img!==null){
            $expl1=explode(',',$img);
            if(!strpos($expl1[0],'image')){
                $err3="File1's format is not accptable";
            }else{
                $img1=base64_decode($expl1[1]);
                $filename1=$itemas->picture;
                $path=public_path().'\storage\img\\'.$filename1;
                file_put_contents($path,$img1);
              
                };
            };
        $itemas->name=$name;
        $itemas->desc=$desc;
        $itemas->mens=$mens;
        $itemas->price=$price;
        $itemas->womens=$womens;
        $itemas->children=$children;
        $itemas->save();
        $err5="Success";
        };

        return response()->json(['err1'=>$err1,'err2'=>$err2,'err3'=>$err3,'err4'=>$err4,'err5'=>$err5]);
    }

    public function plusminus(request $request, $id){
        $plus=$request->input('plus');
        $minus=$request->input('minus');
        $item=Inventory::find($id);
        $msg="Please specify valid number values";
        if($plus>=0 && $minus>=0){
            $item->quantity=$item->quantity+$plus-$minus;
            $item->save();
            $msg="Stock updated";
        };
        return response()->json(['msg'=>$msg]);
    }

    public function remove(request $request, $id){
        $item=Inventory::find($id);
        $item->active="0";
        $item->save();
        //ALSO, WHEN AN ITEM IS TAKEN OUT OF THE STORE, CURRENT CART RECORDS HOLDING THIS ITEM ACROSS ALL ACCOUNTS ARE REMOVED FROM THEIR CARTS TO AVOID CONFLICTS
        $cartRec=Cart::where('product_id','=',$id)->delete();
    }


 
}
