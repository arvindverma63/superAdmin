<?php

namespace App\Http\Controllers;

use App\Logic\Users;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function addUser(Request $request,Users $user){
        $response = $user->addUser($request);
        return $response;
    }
    public function updatePermission(Request $request,Users $user){
        return response()->json($user->updatePermission($request));
    }
}
