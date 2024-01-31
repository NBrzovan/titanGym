<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        
        $user = Auth::user();
        dump($user);   
        session(['token' => $token, 'id' => $user->id]);
    
        $sessionLifetimeInMinutes = 720;
        config(['session.lifetime' => $sessionLifetimeInMinutes]);
    
        return response()->json([
            'success' => 'Uspešno ste se ulogovali!',
            'user' => $user,
            'token' => $token
        ]);
    }
    
}