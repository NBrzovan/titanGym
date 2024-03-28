<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function show($id){
        $adminData = User::getAdmin($id);
        
        return response()->json($adminData);
    }

    public function update(Request $request, $id){
        $admin = User::updateAdmin($request->all(), $id);

        if (!$admin) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return $admin;
    }
}
