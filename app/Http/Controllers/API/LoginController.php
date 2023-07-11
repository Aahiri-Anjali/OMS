<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email'=>'required|email|exists:admins,email','password'=>'required|min:8'
            ]);

        if($validate->fails())
        {
            return response()->json(['errors'=>$validate->errors()]);
        }

        $data = ['email'=>$request['email'],
          'password'=>$request['password']];
        if(auth()->guard('admin')->attempt($data))
        {
            $token = auth()->guard('admin')->user()->createToken('token')->accessToken;
            return response()->json(['token'=>$token]);
        }else{
            return response()->json(['data'=>"you are not authorized"]);
        }
       
    }
}
