<?php

namespace App\Http\Controllers;

use App\Logic\Users;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function otpPage(){
        return view('Auth.otp');
    }
    public function dashboard(Users $user){
        return view('pages.index',['user'=>$user->getAllUser()->json()]);
    }
    public function addUserPage(){
        return view('pages.addUser');
    }
}
