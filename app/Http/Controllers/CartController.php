<?php

namespace App\Http\Controllers;

use App\cart;
use App\product;
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

        return  $cart->with('Product')->get();
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

            return $errors->toJson();
        }
        else{
           if(Cart::where('product_id', '=', $request->product_id)->exists()){

              $cart->where('product_id', $cart->product_id = $request->product_id)->increment('quantity' , 1 );
              return $cart->with('Product')->where('product_id', $request->product_id)->get();

             }else{
                $cart = new Cart;
                $cart->quantity = 1;
                if (Product::where('id', '=', $request->product_id)->exists()) {
                    $cart->product_id = $request->product_id;
                }else{
                    $errors = 'HTTP 404';
                    return $errors;
                }
                $cart->save();
              
                return $cart->select('quantity' , 'product_id')->where('product_id', $request->product_id)->with('Product')->get();
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

      return Cart::whereNotNull('id')->delete();
    //   $deleteall = 'HTTP 200';
     //  return $deleteall;
    }

    public function delete(Cart $cart, Request $request)
    {
        
       if(Cart::where('product_id', '=', $request->product_id)->exists()){
        Cart::where('product_id', '=', $request->product_id)->delete();
        $deleteone = 'HTTP 200';
        return $deleteone;
       
       }else{
        header('Content-Type: application/json; charset: UTF-8');
        $str = '[{"code": "401", "message": "not found"}]';
        $ok = 'HTTP 404';
        return $str;
       }
      
       
    }
}
