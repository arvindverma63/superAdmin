<?php

namespace App\Http\Controllers;

use App\Logic\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginPage(){
        return view('Auth.login');
    }
    public function loginController(Request $request,Login $login){
        $response = $login->login($request);
        if($response->successful()){
            return redirect()->route('verify.otp');
        }else{
            return redirect()->back()->with(['error','Wrong Credentials']);
        }
    }
    public function verifyOtp(Request $request,Login $login){
        $response = $login->verifyOtp($request);
        if($response->successful()){
            $result = $response->json();
            Session::put('token',$result['token']);
            Log::info('session token store',[$result['token']]);
            return redirect()->route('dashboard');
        }
    }
    public function logout(){
        Session::flash('token');
        Session::flash('email');

        return redirect()->route('login');
    }
}
