<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use App\Sales;
use App\Cart;
use App\Inventory;

class paypalcontroller extends Controller
{
    public function start(){
        //create sales record in db with received payment id
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AQYYDrkY3MXeA4WoO18AijNfz0zl8OjGm0rb4ebRGeOb-7MmLjuxw0Ca-fuu84zfz3QtTXF8QRlUExU6',     // ClientID
                'EJvkf7ozTWaRszICRjw_Nx765r5p7hO6aADls7NqxPHZpO7Sp89r2oSWHSQQtjmNJhX0B_dAnXQG91fU'      // ClientSecret
            )
    );
        
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $carts=Cart::where('user_id','=',session('id'))->get();
        $totalas=0;
        $index = 0;
        $tempid=time().rand();
        $items = array();
          foreach($carts as $cart){
              $Sale= new Sales;
              $Sale->user_id=session('id');
              $Sale->product_id=$cart->product_id;
              $Sale->quantity=$cart->quantity;
              $Sale->address="-";
             $Sale->email="-";
             $Sale->total=$cart->quantity*$cart->product->price; //cart->item.price*cart->quantity
              $Sale->Status="0";
              $Sale->created_at=NOW();
              $Sale->updated_at=NOW();
              $Sale->payment_id= $tempid;
              $Sale->Ship_Name="";
              $Sale->save();
              $totalas=$totalas+$Sale->total;
        

             
          
            $items[$index] = new Item();
            $items[$index]->setName($cart->product->name)
                 ->setCurrency('USD')
                 ->setSku($cart->product->id)
                 ->setQuantity($cart->quantity)
                 ->setPrice($cart->product->price);
                 $index++;
                
          };

     //   $item1 = new Item();
     //   $item1->setName('Ground Coffee 40 oz')
    //        ->setCurrency('USD')
     //       ->setQuantity(1)
     //       ->setSku("123123") // Similar to `item_number` in Classic API
     //       ->setPrice(7.5);
     //   $item2 = new Item();
     //   $item2->setName('Granola bars')
       //     ->setCurrency('USD')
        //    ->setQuantity(5)
      //      ->setSku("321321") // Similar to `item_number` in Classic API
        //    ->setPrice(2);
     
        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($totalas);


        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($totalas)
            ->setDetails($details);
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
             ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

            
       // $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('api/payconfirm')) // URL THAT RECEIVES THE RESPONSE, LEADING INTO FUNCTION "CONFIRM()"!!
            ->setCancelUrl("https://localhost/ExecutePayment.php?success=false");
         
            
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);
          
       //CHANGE TEMP ID TO REAL PAYMENT ID
       $salechange=Sales::where('payment_id','=',$tempid)->get();
       foreach($salechange as $change){
            $change->payment_id=$payment->id;
            $change->save();
       };
     
        $approvalUrl = $payment->getApprovalLink();
        return redirect($approvalUrl);
    }


    public function confirm(request $request){
        //if response status "confirm" then edit (where payment id matches in db) the sales record to confirmed
      //  if (isset($request->input('success')) && $request->input('success')=='true') {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AQYYDrkY3MXeA4WoO18AijNfz0zl8OjGm0rb4ebRGeOb-7MmLjuxw0Ca-fuu84zfz3QtTXF8QRlUExU6',     // ClientID
                'EJvkf7ozTWaRszICRjw_Nx765r5p7hO6aADls7NqxPHZpO7Sp89r2oSWHSQQtjmNJhX0B_dAnXQG91fU'      // ClientSecret
            )
    );
                $paymentId = $_GET['paymentId'];
                $payment = Payment::get($paymentId, $apiContext);
     
                $execution = new PaymentExecution();
                $execution->setPayerId($_GET['PayerID']);
           
                $transaction = new Transaction();
                $amount = new Amount();
                $details = new Details();
        
                $changestatus=Sales::where('payment_id','=', $paymentId)->get();
                $totalas=0;
              
                foreach($changestatus as $tot){
                    $totalas=$totalas+$tot->total;
                };
          
                $details->setShipping(0)
                    ->setTax(0)
                    ->setSubtotal($totalas);
            
                $amount->setCurrency('USD');
                $amount->setTotal($totalas);
                $amount->setDetails($details);
                $transaction->setAmount($amount);
            
                $execution->addTransaction($transaction);

                //CHECK, TRUNC, REDIR HERE
                $errquant=null;
                foreach($changestatus as $checkQuant){
                    $isitless=Inventory::find($checkQuant->product_id);
                    if($checkQuant->quantity>$isitless->quantity){
                        $WipeCart=Cart::where('user_id','=',session('id'))->delete();
                        return redirect(url('/QuantityError'));
                    };
                };
              
               
            
              
                $result = $payment->execute($execution, $apiContext);
                foreach($changestatus as $status){        
                    $inv=Inventory::find($status->product_id);
                    $inv->quantity=$inv->quantity-$status->quantity;
                    $inv->save();
                    $status->status="1";
                    $status->address=$result->payer->payer_info->shipping_address->country_code.', '.$result->payer->payer_info->shipping_address->city.', '.$result->payer->payer_info->shipping_address->line1.', '.$result->payer->payer_info->shipping_address->postal_code;
                    $status->Ship_name=$result->payer->payer_info->shipping_address->recipient_name;
                    $status->email=$result->payer->payer_info->email;
                    $status->save();
                };
                $WipeCart=Cart::where('user_id','=',session('id'))->delete();
                return redirect(url('/'));

                //If everything' sccessful you'll be taken to this part of the code- redirected back to the homepage (will leave the resolution as homepage for now)
}
}
