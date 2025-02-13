<?php

namespace App\Http\Controllers;

use App\Logic\SocialMedia;
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
    public function socialMedia(SocialMedia $socialMedia)
{
    $response = $socialMedia->getAllUsers();

    // Convert response to array if it's a JSON string
    if (is_string($response)) {
        $data = json_decode($response, true);
    } elseif (is_object($response) && method_exists($response, 'json')) {
        $data = $response->json();
    } else {
        $data = is_array($response) ? $response : [];
    }

    return view('SocialMedia.socialMedia', compact('data'));
}



}
