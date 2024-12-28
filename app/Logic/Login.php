<?php

namespace App\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Login
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        Log::info('Attempting login for email: ', ['email' => $validated['email']]);

        // Get the API base URL from the environment
        $baseUrl = env('API_BASE_URL');
        if (!$baseUrl) {
            Log::error('API_BASE_URL is not set in .env file.');
            return redirect()->back()->withErrors(['error' => 'Internal error, please try again later.']);
        }

        // Send login request to external API
        $response = Http::post($baseUrl . '/login', [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if ($response->successful()) {
            Log::info('Login successful: ', ['response' => $response->body()]);

            // Store email in session
            Session::put('email', $validated['email']);

            // Redirect to OTP verification
            return redirect()->route('verify.otp');
        } else {
            // Log detailed error information
            Log::error('Login failed: ', [
                'status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            // Handle different error responses
            if ($response->status() === 401) {
                return redirect()->back()->with(['error' => 'Invalid credentials']);
            }

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }


    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'string|required',
        ]);

        $baseUrl = env('API_BASE_URL');
        $email = Session::get('email');

        $response = Http::post($baseUrl . '/verify-otp', [
            'email' => $email,
            'otp' => $validated['otp'],
        ]);

        if ($response->successful()) {
            Log::info($response);
            return $response;
        } else {
            Log::error($response);
        }
    }
}
