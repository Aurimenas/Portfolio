<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
 //use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\Store;
use Illuminate\Session\SessionManager;
use App\Accounts;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Crypt;

class logincontroller extends Controller
{
    public function username(){
        $id=session('id');
        $usr=Accounts::find($id);
        $usn=$usr->usn;
        return response()->json(['usn'=>$usn]);
    }

    public function index(request $request){
       
        //validation
        $usn=$request->input('usn');
        $pwd=$request->input('pwd');
        $err1=null;
        $err2=null;
        $err3=null;
        $err4=null;
        $err5=null;
        $err6=null;
        if(empty($request->input('usn'))){
            $err1="Please enter your username";
           
        } elseif(empty($request->input('pwd'))){
            $err2="Please enter your password";
             } else {
        if($acc=Accounts::where('usn','=',$request->input('usn'))->first()){
            if(Crypt::decryptString($acc->pwd)===$request->input('pwd')){
                Session::token();
                Session::put('id', $acc->id);
                Session::put('grp', $acc->group);
                Session::save();
                $err6=Session('id');
                $err5="Success";
               // return redirect(url('/'));
            }else
            { 
                $err3="Incorrect password";
            };
        } else {
            $err4="There is no such user";
        };
    };
 
        return response()->json(['err1'=> $err1, 'err2'=> $err2, 'err3'=> $err3, 'err4'=> $err4, 'err5'=> $err5,'err6'=>$err6]);
     
    }

    public function logout(){
        Session::token();
        Session::flush();
        return redirect(url('/'));
    }
     
    public function register(request $request){
        $usn=$request->input('usn');
        $pwd1=$request->input('pwd1');
        $pwd2=$request->input('pwd2');
      //  return response()->json(['err9'=> null, 'err8'=> $pwd1, 'err9'=> $pwd2,'usn'=>$usn]);
        $err6=null;
        $err7=null;
        $err8=null;
        $err9=null;
        $err10=null;
        if(strlen($usn)<5 Or Accounts::where('usn','=',$usn)->first()){
            $err6="Your entered username is too short or already taken";
        };
        if(strlen($pwd1)<5){
            $err7="Your entered password is too short";
        };
        if($pwd2!==$pwd1){
            $err8="Your entered passwords do not match";
        };
        if($err6==null And $err7==null And $err8==null){
            $err9="Succesfully registered, yo uare automatically logged in!";
        
        $acc=new Accounts;
        $acc->usn=$request->input('usn');
        $acc->pwd=$request->input('pwd1');
        $acc->group="user";
        $acc->save(); //creates the record
        //automatically logs in with the new account's data
        Session::token();
        Session::put('id',Accounts::count());
        Session::put('group','user');
        Session::save();
      
        
    };
    return response()->json(['err6'=> $err6, 'err7'=> $err7, 'err8'=> $err8, 'err9'=> $err9]);
    }
    public function update(request $request){
        $id=session('id');
        $usr=Accounts::find($id);
        $pwd1=$request->input('pwd1');
        $pwd2=$request->input('pwd2');
        $ogpwd=$request->input('ogpwd');
        $usn=$request->input('usn');
        $err1=null;
        $err2=null;
        $err3=null;
        $err4=null;
        $err5=null;
        if(Crypt::decryptString($usr->pwd)!==$ogpwd){
            $err2="Incorrect password";
        };
        if(Accounts::where([['usn','=',$usn],['id','!=',$id]])->first())
        $err1="Username too short or already taken";
        if(strlen($pwd1)<5){
        $err3="New password is too short";
        };
        if($pwd1!==$pwd2 OR strlen($pwd2)<5){
        $err4="New password is too short or doesnt match";
        };
        if($err1==null && $err2==null  && $err3==null  && $err4==null){
            $account=Accounts::find($id);
            $account->usn=$usn;
            $account->pwd=$pwd1;
            //$account->group=$usr->group;
            $account->updated_at=NOW();
           // $account->created_at=NOW();
            $account->save();
            $err5="Account info updated";
            
           
        };
        return response()->json(['err1'=>$err1,'err2'=>$err2,'err3'=>$err3,'err4'=>$err4,'err5'=>$err5]);
    }

    public function auth(){
        if(session('grp')==="Admin"){
            $res="Authenticated";
        }else{
            $res="Redir";
        };
        return response()->json(['re'=>$res]);
    }
}
