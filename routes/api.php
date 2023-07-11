<?php

use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CustomerLoginController;
use App\Http\Controllers\API\ItemCategoryController;
use App\Http\Controllers\API\ItemMasterController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\SubBrandController;
use App\Http\Controllers\API\SubCategoryController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/login',[LoginController::class,'login']);

Route::middleware('auth:api')->group(function(){
   Route::post('/itemcategory', [ItemCategoryController::class,'store']);
   Route::delete('/itemcategory/delete/{id}',[ItemCategoryController::class,'destroy']);
   Route::get('/itemcategory/view/{id}',[ItemCategoryController::class,'view']);
   Route::get('/itemcategory/list',[ItemCategoryController::class,'list']);


   Route::post('/subcategory',[SubCategoryController::class,'store']);
   Route::delete('/subcategory/delete/{id}',[SubCategoryController::class,'destroy']);
   Route::get('/subcategory/view/{id}',[SubCategoryController::class,'view']);
   Route::get('/subcategory/list',[SubCategoryController::class,'list']);


   Route::post('/brand',[BrandController::class,'store']);
   Route::delete('/brand/delete/{id}',[BrandController::class,'destroy']);
   Route::get('/brand/view/{id}',[BrandController::class,'view']);
   Route::get('/brand/list',[BrandController::class,'list']);

   Route::post('/subbrand',[SubBrandController::class,'store']);
   Route::delete('/subbrand/delete/{id}',[SubBrandController::class,'destroy']);
   Route::get('/subbrand/view/{id}',[SubBrandController::class,'view']);
   Route::get('/subbrand/list',[SubBrandController::class,'list']);

   Route::post('/customer',[CustomerController::class,'store']);
   Route::delete('/customer/delete/{id}',[CustomerController::class,'destroy']);
   Route::get('/customer/list',[CustomerController::class,'list']);

   Route::post('/itemmaster',[ItemMasterController::class,'store']);
   Route::delete('/itemmaster/delete/{id}',[ItemMasterController::class,'destroy']);
   Route::get('/itemmaster/list',[ItemMasterController::class,'list']);


});

Route::get('/customer/login',[CustomerLoginController::class,'login']);

Route::middleware('auth:api_customer')->group(function(){

   Route::post('/order',[OrderController::class,'store']);
   Route::delete('/order/delete/{id}',[OrderController::class,'destroy']);


});



Route::get('/sage',function(){
// $response = Http::withBasicAuth('anjaliaahiri123@gmail.com', 'abc@1234')
//     ->get('https://api.columbus.sage.com/uk/sage200/accounts/v1/departments');
// $data = $response->json();
// return $data;

   // $client = new Client();
   //      $response = $client->request('GET', 'https://api.columbus.sage.com/uk/sage200/accounts/v1/banks', [
   //          'auth' => [
   //            'anjaliaahiri123@gmail.com',
   //            'abc@1234'
   //          ]
   //      ]);
      //   $data = json_decode($response->getBody(), true);
      //   return response()->json($data);
      $data = Customer::all();
      return $data;
});