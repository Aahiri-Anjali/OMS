<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerLoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email'=>'required|email|exists:customers,email','password'=>'required|min:8'
            ]);

        if($validate->fails())
        {
            return response()->json(['errors'=>$validate->errors()]);
        }

        $data = ['email'=>$request['email'],
          'password'=>$request['password']];
        if(auth()->guard('customer')->attempt($data))
        {
            $token = auth()->guard('customer')->user()->createToken('token')->accessToken;
            return response()->json(['token'=>$token]);
        }else{
            return response()->json(['data'=>"you are not authorized"]);
        }
       
    }
}
