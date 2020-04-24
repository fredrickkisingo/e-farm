<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Purchase;
use Gathuku\Mpesa\Facades\Mpesa;
use Session;
use App\Post;


class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $user_id = auth()->user()->id;//this is to allow the mpesa transaction to take place for the cart contents of that specific user
    
            $cart_select= Cart::where('user_id',$user_id)->get();
    
           //here we are saving the cart items purchased by the user into the purchases table
            foreach ($cart_select as $cart_item) {
               
                $purchase = new Purchase;
    
    
                $purchase->session_id = $cart_item->session_id;
                $purchase->product_id = $cart_item->product_id;
                $purchase->product_name = $cart_item->product_name;
                $purchase->product_desc = $cart_item->product_desc;
                $purchase->user_id = auth()->user()->id; //the user id will be added
                $purchase->qty = $cart_item->qty;
                $purchase->price = $cart_item->price;
                $purchase->total_price = $cart_item->total_price;
                $purchase->farmer_id = $cart_item->farmer_id;
                $purchase->save();
            }
            if (Cart::where('user_id', '=', $user_id)->exists()) {
                    $cart_price= new Cart;
                    $entry = Cart::where(['user_id' => $user_id])->pluck('total_price')->sum();
    
                
                   //here is where we are executing the mpesa payment
                    $phone_num= $request->input('phone_number');
    
                    $pesa=Mpesa::express($entry,$phone_num,'Cart products payment','Testing Payment');
                    //decode response to array
                    $decode = json_decode($pesa,true);
                    //here check if there was an error with the checkout request
                    if(empty($decode['requestId'])){

                        $MerchantRequestID = $decode['MerchantRequestID'];
                        $CheckoutRequestID = $decode['CheckoutRequestID'];
                        $ResponseCode = $decode['ResponseCode'];
                        $ResponseDescription = $decode['ResponseDescription'];
                        $CustomerMessage = $decode['CustomerMessage'];
                        
                        /*
                        ideally here you should store the payment status on the
                         database since the request was successful
                         */

                        
                    
                        return redirect('/posts')->with('success','Success.Request accepted for processing');
                        
                    }
                    //here the payment failed... so we should notify the user that they should retry
                    $requestId = $decode['requestId'];
                    $errorCode = $decode['errorCode'];
                    $errorMessage = $decode['errorMessage'];
                    
                    //here you update the payment status in the database with the errorMessage
                    return $errorMessage;
            }
                $responseMpesa=Mpesa::lnmo_query();
                $decoded = json_decode($responseMpesa);

                //capture the payment data in variables...
                $resultCode = $decoded->Body->stkCallback->ResultCode;
                $resultDesc = $decoded->Body->stkCallback->ResultDesc;
                $CheckoutRequestID = $decoded->Body->stkCallback->CheckoutRequestID;
                $MerchantRequestID = $decoded->Body->stkCallback->MerchantRequestID;

                //Callback Meta Data...
                $CallbackMetadata = $decoded->Body->stkCallback->CallbackMetadata;

                foreach($CallbackMetadata as $key=>$value){

                $Amount             = $value['0']->Value;// Payment Amount..
                $mpesaRef            = $value['1']->Value;// Payment Referrence MPESA
                $mpesaPhoneNumber   = $value['4']->Value;// Payment Phone Number

                }

            
          
            //deletes cart entries of the specific user logged in
            Cart::where('user_id', $user_id)->delete();
    
            return redirect('/dashboard')->with('success', 'Purchased Items Added to Your History');
    
    
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $purchase_items = Purchase::find($id);

         if (auth()->user()->id !== $purchase_items->user_id) {
             return redirect('/cart')->with('error', 'Unauthorized Access');
         }
 
         $purchase_items->delete();
         return redirect('/dashboard')->with('success', 'Item removed from Purchase History');
     
    }
}
