<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request) {
        return $this->authService->login($request);
    }

    public function logout(Request $request) {
        Session::forget('token');

        return response()->json(['success' => 'You have successfully logged out']);
    }
}
