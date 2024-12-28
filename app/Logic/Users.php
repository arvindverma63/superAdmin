<?php

namespace App\Logic;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Users{
    public function getAllUser(){
        $baseUrl = env('API_BASE_URL');
        $token = Session::get('token');

        $response = Http::withHeaders([
            'Authorization'=>'Bearer'.$token,
        ])->get($baseUrl.'/super-admin/users');

        if($response->successful()){
            Log::info('getAllUser: ',[$response]);
            return $response;
        }
        else{
            Log::error('error for getAllUsers ',[$response]);
            return $response;
        }
    }
}
