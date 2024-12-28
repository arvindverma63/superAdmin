<?php

namespace App\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Login{
    public function login(Request $request){
        $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        Log::info('attempt to login : ',[$validated]);
        $baseUrl = env('API_BASE_URL');
        Log::info('attempt baseUrl : ',[$baseUrl]);
        $response = Http::post($baseUrl.'/login',[
            'email'=>$validated['email'],
            'password'=>$validated['password']
        ]);

        if($response->successful()){
            Log::info($response);

            Session::put('email',$validated['email']);

            return $response;
        }else{
            Log::error($response);
            return $response;
        }

    }

    public function verifyOtp(Request $request){
        $validated = $request->validate([
            'otp'=>'string|required',
        ]);

        $baseUrl = env('API_BASE_URL');
        $email = Session::get('email');

        $response = Http::post($baseUrl.'/verify-otp',[
            'email'=>$email,
            'otp'=>$validated['otp'],
        ]);

        if($response->successful()){
            Log::info($response);
            return $response;
        }
        else{
            Log::error($response);
        }
    }
}
