<?php

namespace App\Http\Controllers;

use App\Logic\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function addUser(Request $request,Users $user){
        $response = $user->addUser($request);
        return $response;
    }
}
