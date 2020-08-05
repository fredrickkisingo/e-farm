<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Post;
use App\User;
use DB;
use Illuminate\Support\Facades\Storage;
use Gathuku\Mpesa\Facades\Mpesa;

class CartsController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');  
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;//getting id of logged user
        $user =User::find($user_id);
        return view('pages.cart')->with('carts',$user->carts);
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
     //
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
        $user_id = auth()->user()->id;
        //use session id to uniquely identify each item added to the cart
        $session_id = session()->get('_token');

        $post_select = Post::find($id); //finding the product selected based on its id

        if (Cart::where('session_id', '=', $session_id)->exists()) {
            //Check whether product exist if yes increase quantity` the 2 $entry working concurrently
            $entry = Cart::where(['session_id' => $session_id, 'product_id' => $id])->increment('qty', 1);
            $entry = DB::update("UPDATE carts SET total_price=price* qty "); //update total_price column

     //"if entry" checks if there exists any cart items already  and if there is not it will create a new cart the first if statement had already failed
            if (!$entry) {

                $cart_item = new Cart;

                //adding selected item into cart
                $cart_item->session_id = $session_id;
                $cart_item->product_id = $post_select->id;
                $cart_item->product_name = $post_select->title;
                $cart_item->product_desc = $post_select->body;

                $cart_item->user_id = auth()->user()->id; //the user id will be added
                $cart_item->qty = 1;
                $cart_item->price = $post_select->products_price;
                $cart_item->location = $post_select->location;
                $cart_item->cover_image = $post_select->cover_image;
                $cart_item->farmer_id = $post_select->user_id;


                $cart_item->save();
            }
        } else {
            $cart_item = new Cart;

            //adding selected item into an existing cart
            $cart_item->session_id = $session_id;
            $cart_item->product_id = $post_select->id;
            $cart_item->product_name = $post_select->title;
            $cart_item->product_desc = $post_select->body;
            $cart_item->location = $post_select->location;

            $cart_item->user_id = auth()->user()->id; //the user id will be added
            $cart_item->qty = 1;
            $cart_item->price = $post_select->products_price;
            
           // $cart_item->total_price = DB::table('carts')->selectRaw('SUM(qty*price) as total')->pluck('total');
            $cart_item->cover_image = $post_select->cover_image;
            $cart_item->farmer_id = $post_select->user_id;
            $cart_item->save();
        }
        return redirect('/posts')->with('success', 'Item Added to Cart');
    }

    


    public function destroy($id)
    {
          $cart_items = Cart::find($id);

          if (auth()->user()->id !== $cart_items->user_id) {
              return redirect('/carts')->with('error', 'Unauthorized Access');
          }
  
  
          $cart_items->delete();
          return redirect('/carts')->with('success', 'Item removed from Cart');
      
    }

       
    
}
