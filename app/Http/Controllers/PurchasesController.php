<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Purchase;
use Gathuku\Mpesa\Facades\Mpesa;
use Session;
use App\Post;
use App\MpesaPayment;
use Illuminate\Support\Facades\Log;
use App\StkPush;
use App\Stk_push_payments;
use Illuminate\Support\Facades\Response;


class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $stk_push_payments=Stk_push_payments::OrderBy('created_at')->paginate(10);
      return view('purchases.index')->with('stk_push_payments',$stk_push_payments);
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
        
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public  function format_lmno($data){
        //$data is the json encoded pqyload from mpesa.
           $data = json_decode($data);
           $tmp = $data->Body->stkCallback;
           $master = array();
           if($tmp->ResultCode == 0){
           foreach($data->Body->stkCallback->CallbackMetadata->Item as $item){
               $item = (array) $item;
               $master[$item['Name']] = ((isset($item['Value'])) ? $item['Value'] : NULL);

           }
           }
           $master = (object) $master;
           $master->ResultCode = $tmp->ResultCode;
           $master->MerchantRequestID = $tmp->MerchantRequestID;
           $master->CheckoutRequestID = $tmp->CheckoutRequestID;
           $master->ResultDesc = $tmp->ResultDesc;

           return $master;

}
    public function receiveStkpushpayments(Request $request){
        
         \Log::info($request->getContent()); // will log a copy in logs for that day
            
         $data=$this->format_lmno($request->getContent());
            


          
             if ($data->ResultCode == 0){          
                
                // saving the information into the table in MySQL  
                  
                $stk_push_payments = new Stk_push_payments; 
                $stk_push_payments->amount= $data->Amount;
                $stk_push_payments->phonenumber= $data->PhoneNumber;
                $stk_push_payments->MpesaReceiptNumber= $data->MpesaReceiptNumber;
                $stk_push_payments->CheckoutRequestID= $data->CheckoutRequestID;
                $stk_push_payments->MerchantRequestID= $data->MerchantRequestID;
                $stk_push_payments->ResultDesc = $data->ResultDesc;
                $stk_push_payments->status = 'successful';
                //$stk_push_payments->user_id= auth()->user()->id;
                $stk_push_payments->save();

                return redirect('/dashboard')->with('success', 'Purchased Items Added to Your History');
               }else{
                
                
                
                $stk_push_payments = new Stk_push_payments;
                $stk_push_payments->ResultDesc = $data->ResultDesc;
                $stk_push_payments->CheckoutRequestID= $data->CheckoutRequestID;
                $stk_push_payments->MerchantRequestID= $data->MerchantRequestID;
                $stk_push_payments->amount='0';
                $stk_push_payments->phonenumber='0';
                $stk_push_payments->MpesaReceiptNumber='0';
                $stk_push_payments->status = 'failed';
               // $stk_push_payments->user_id = auth()->user()->id;

                $stk_push_payments->save();

                // return redirect('/dashboard')->with('success', 'Purchased Items Added to Your History');
    
            }
              
    }
    public function store(Request $request)
    {
           
            //this is to allow the mpesa transaction to take place for the cart contents of that specific user
            $user_id = auth()->user()->id;
            
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
                   //here is where we are placing the phone number to complete the mpesa payment
                    $phone_num = $request->input('phone_number');
            /*
                 Request has been sent for processing to MPESA ,now it's checking whether it was successful or it failed
            */

            $pesa      = Mpesa::express($entry,$phone_num,'Cart products payment','Testing Payment');
             $response  = json_decode($pesa);
            //  dd($response);
             

             
           

          
               
         //  check if the Payment was Successful...
         
        if(isset($response->MerchantRequestID)){

          $MerchantRequestID = $response->MerchantRequestID;
          $CheckoutRequestID = $response->CheckoutRequestID;
          $ResponseCode = $response->ResponseCode;
          $ResponseDescription = $response->ResponseDescription;
          $CustomerMessage = $response->CustomerMessage;
             
          switch($response->ResponseCode){
            case 0:
            /*
            Here insert the payment data to the mpesa table
            also update the order status to maybe confirmation
            */
            $succ = new MpesaPayment;

            $succ->CheckoutRequestID= $CheckoutRequestID;
            $succ->merchantrequest_i_d= $MerchantRequestID;
            $succ->ResultDesc=$ResponseDescription;
            $succ->ResponseCode=$ResponseCode;
            $succ->save();
            //deletes cart entries of the specific user logged in
            Cart::where('user_id', $user_id)->delete();

            
            return redirect('/dashboard')->with('success', 'Purchased Items Added to Your History');
            break;

          }

        }else{
        //Here the Payment failed. Either the Telephone Number was invalid or the first failed request was not cancelled by the user
          
          if($response->requestId){

                    $requestId    = $response->requestId;
                    $errorCode    = $response->errorCode;
                    $errorMessage = $response->errorMessage;                               
                /*
                Failed payment request....
                update the Order status here and the Payment status on the MPESA Payments table.
                */
                 return back()->with('error','Try Again');
                }
            }
        }
                      
        return redirect('/dashboard')->with('success', 'Purchased Items Added to Your History');

      
    
    }  
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
             return redirect('/carts')->with('error', 'Unauthorized Access');
         }
 
         $purchase_items->delete();
         return redirect('/dashboard')->with('success', 'Item removed from Purchase History');
     
    }
}
