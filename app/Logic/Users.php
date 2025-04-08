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
    public function addUser(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'restaurantName' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        Log::info('validated request for add User', [$validated]);
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
                'role' => 'admin',
                'password' => $validated['password'],
                'password_confirmation' => $validated['password'],
            ]);

            Log::info('Response', [$response]);
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

    public function updatePermission(Request $request)
    {
        try {
            // Validate incoming request data
            $validated = $request->validate([
                'restaurantId' => 'required|string',
                'permission' => 'required|in:0,1'
            ]);

            // Get base URL and token
            $baseUrl = env('API_BASE_URL');
            $token = Session::get('token');

            // Check if token exists
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication token not found'
                ], 401);
            }

            // Make the API call
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])->put($baseUrl . '/admin/update-permission', [
                'restaurantId' => $validated['restaurantId'],
                'permission' => $validated['permission'],
            ]);

            // Check if the API call was successful
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission updated successfully',
                    'data' => $response->json()
                ], 200);
            }

            // Handle API errors
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permission: ' . $response->body(),
                'errors' => $response->json()
            ], $response->status());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
