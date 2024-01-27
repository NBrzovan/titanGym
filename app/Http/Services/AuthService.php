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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Morate uneti e-mail adresu.',
            'email.email' => 'Unesite validnu e-mail adresu.',
            'password.required' => 'Morate uneti lozinku.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }
    
        $credentials = $request->only('email', 'password');
    
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Uneli ste pogrešne podatke']);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token nije kreiran'], 500);
        }
    
        $user = User::where('email', $request->email)->first();
    
        Session::put('token', $token);
    
        return response()->json([
            'success' => 'Uspešno ste se ulogovali!',
            'user' => $user,
            'token' => $token
        ]);
    }
    
}