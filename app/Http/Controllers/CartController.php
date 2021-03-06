<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {

       return $cart->with('Product')->get();
       
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
    public function store(Request $request, Cart $cart)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required'
        ]);
         
        if ($validator->fails()) {
           
            $errors = $validator->errors();

            //return $errors->toJson();
            return response(null, 422);
            
        }
        else{
         
               
                if (Product::where('id', '=', $request->product_id)->exists()) {
                    $cart = new Cart;
                    if(Cart::where('product_id', '=', $request->product_id)->exists()){

                        $cart->where('product_id', $cart->product_id = $request->product_id)->increment('quantity' , 1 );
                       
         
                     }
                     else{
                        $cart->quantity = 1;
                     }
                   
                    $cart->product_id = $request->product_id;
                    $cart->save();
                    return $cart->with('product')->select( 'product_id', 'quantity')->get();  

                    }else{
                       return response(null, 404);
                    }


                
              
               
              
               
           
           
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(cart $cart)
    {
       // Cart::truncate();
        Cart::whereNotNull('id')->delete();
       return response('http 200', 200);
    
       
    }

    public function delete(Cart $cart, Request $request)
    {
       if(Cart::where('product_id', '=', $request->product_id)->exists()){
        Cart::where('product_id', '=', $request->product_id)->delete();
      
        return response(null, 200);
       
       }else{
       
        return response(null, 404);
       }
      
       
    }
}
