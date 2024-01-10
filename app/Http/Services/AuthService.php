<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthService {

    public function login($request) {
        Log::info('Pozivam login funkciju');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }
    
        $credentials = $request->only('email', 'password');
    
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials']);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    
        $user = User::where('email', $request->email)->first();
    
        Session::put('token', $token);
    
        return response()->json([
            'success' => 'You have successfully logged in!',
            'user' => $user,
            'token' => $token
        ]);
    }
    
}