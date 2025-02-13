<?php

namespace App\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SocialMedia
{
    protected $token;
    protected $base_url;

    public function __construct()
    {
        // It's better to get the token in each method instead of the constructor
        $this->base_url = env('API_BASE_URL');
    }

    public function adduser(Request $request)
    {
        // Fetch token inside method to ensure it's always available
        $this->token = Session::get('token');

        // Log the incoming request (excluding sensitive data)
        Log::info('Adding influencer', [
            'influencer' => $request->input('influencer'),
            'location' => $request->input('location'),
            'price' => $request->input('price'),
            'available' => $request->input('available'),
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->post($this->base_url . '/social-media', [
                'influencer' => $request->input('influencer'),
                'details' => $request->input('details'),
                'insta' => $request->input('insta'),
                'facebook' => $request->input('facebook'),
                'youtube' => $request->input('youtube'),
                'location' => $request->input('location'),
                'offers' => $request->input('offers'),
                'price' => $request->input('price'),
                'available' => $request->input('available') ? true : false,
            ]);

            if ($response->successful()) {
                Log::info('Influencer added successfully', [
                    'response' => $response->json()
                ]);

                return response()->json([
                    'message' => 'Influencer added successfully!',
                    'data' => $response->json()
                ], 201);
            } else {
                Log::warning('Failed to add influencer', [
                    'status' => $response->status(),
                    'error' => $response->json()
                ]);

                return response()->json([
                    'message' => 'Failed to add influencer',
                    'error' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error while adding influencer', [
                'exception' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllUsers()
    {
        $this->token = Session::get('token');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->get($this->base_url . '/social-media');

            if ($response->successful()) {
                return $response->json(); // Ensuring it returns an array
            } else {
                return []; // Return an empty array if API fails
            }
        } catch (\Exception $e) {
            Log::error('Error fetching users', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
