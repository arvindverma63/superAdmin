<?php

namespace App\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Users
{
    public function getAllUser()
    {
        $baseUrl = env('API_BASE_URL');
        $token = Session::get('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer' . $token,
        ])->get($baseUrl . '/super-admin/users');

        if ($response->successful()) {
            Log::info('getAllUser: ', [$response]);
            return $response;
        } else {
            Log::error('error for getAllUsers ', [$response]);
            return $response;
        }
    }
    public function addUser(Request $request){
        // Validate the incoming request
        $validated = $request->validate([
            'restaurantName' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        Log::info('validated request for add User',[$validated]);
        // Base URL and token retrieval
        $baseUrl = env('API_BASE_URL');
        $token = Session::get('token');

        // Send HTTP POST request
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($baseUrl . '/super-admin/add-restaurant', [
                'name' => $validated['restaurantName'],
                'email' => $validated['email'],
                'role'=>'admin',
                'password' => $validated['password'],
                'password_confirmation'=>$validated['password'],
            ]);

            Log::info('Response',[$response]);
            // Handle response success or failure
            if ($response->successful()) {
                return back()->with('success', 'Restaurant added successfully.');
            } else {
                return back()->withErrors([
                    'error' => $response->json('message') ?? 'Failed to add the restaurant.',
                ]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions during the request
            return back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }
}
