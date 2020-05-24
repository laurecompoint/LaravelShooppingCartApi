<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/cart', 'CartController')->only([
    'index', 'store'
]);
Route::apiResource('/products', 'ProductController');

Route::middleware('api')->delete('/cart/{product_id}', 'CartController@delete');
Route::middleware('api')->delete('/cart', 'CartController@destroy');
