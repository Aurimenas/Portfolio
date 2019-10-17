<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Settings;
use Illuminate\Support\Facades\Artisan;

class settingscontroller extends Controller
{
    public function home(){
        if(file_exists(public_path('/storage/img'))){
        return view('welcome');
        }else{
            Artisan::call('storage:link'); //If this happens to be the first visit, it should generate a sym-link between storage and public dirs to access media
            return view('welcome');
        }
    }
    public function save(request $request){
        $tax=$request->input('tax');
        $glob=$request->input('glob');
        $car1=$request->input('img1');
        $car2=$request->input('img2');
        $car3=$request->input('img3');
        $err2=null;
        $err1=null;

        if($tax<0 OR $glob<0){
            $err1="Tax rates or sales can't be have negative values!";
            $settings=Settings::find(1);
        }else{
        $settings=Settings::find(1);
        if($car1!==null){
            $expl1=explode(',',$car1);
            if(!strpos($expl1[0],'image')){
                $err2="File1's format is not accptable";
            }else{
                $img1=base64_decode($expl1[1]);
                $filename1="carousel1.png";
                $path=public_path().'\storage\img\\'.$filename1;
                file_put_contents($path,$img1);
                $settings->car1=$filename1;
                };
        };
        if($car2!==null){
            $expl2=explode(',',$car2);
            if(!strpos($expl2[0],'image')){
                $err2="File2's format is not accptable";
            }else{
                $img2=base64_decode($expl2[1]);
                $filename2="carousel2.png";
                $path=public_path().'\storage\img\\'.$filename2;
                file_put_contents($path,$img2);
                $settings->car2=$filename2;
                };
        };
        if($car3!==null){
            $expl3=explode(',',$car3);
            if(!strpos($expl3[0],'image')){
                $err2="File3's format is not accptable";
            }else{
                $img3=base64_decode($expl3[1]);
                $filename3="carousel3.png";
                $path=public_path().'\storage\img\\'.$filename3;
                file_put_contents($path,$img3);
                $settings->car3=$filename3;
                };
        };
        $settings->tax=$tax;
        $settings->globalSale=$glob;
        $settings->save();  
        };
        return response()->json(['err1'=>$err1,'settings'=>$settings,'err2'=>$err2]);    
    }
    public function load(){
        if($settings=Settings::find(1)){
            return response()->json(['settings'=>$settings]);
        }else{
            $settings=new Settings;
            $settings->tax=0;
            $settings->globalSale=0;
            $settings->car1="image1.jpg";
            $settings->car2="image2.jpg";
            $settings->car3="image3.jpg";
            $settings->save();
            return response()->json(['settings'=>$settings]);
        };
    }
}
