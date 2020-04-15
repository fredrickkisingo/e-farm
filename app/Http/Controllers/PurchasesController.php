<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Purchase;
use Gathuku\Mpesa\Facades\Mpesa;


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
        if (Cart::where('user_id', '=', $user_id)->exists()) {
                $cart_price= new Cart;
                $entry = Cart::where(['user_id' => $user_id])->pluck('total_price')->sum();

            
                $phone_num= $request->input('phone_number');
                $expressResponse=Mpesa::express($entry,$phone_num,'Cart products payment','Testing Payment');   
        }
        if ($expressResponse.ResponseCode == "0" ){                 
            return view(posts.index)->with('success', 'Mpesa Successful');
        }
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
            $purchase->cover_image = $cart_item->cover_image;
            $purchase->farmer_id = $cart_item->user_id;
            $purchase->location = $cart_item->location;

            $purchase->save();
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
