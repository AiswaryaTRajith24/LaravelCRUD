<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // User Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized User!!!'], 401);
        }

        return response()->json(['token' => $token]);
    }

     // Logout
     public function logout()
     {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to logout, try again'], 500);
        }
     }
 
     // Refresh Token
     public function refresh()
     {
        try {
            return response()->json([
                'token' => JWTAuth::refresh(JWTAuth::getToken())
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token refresh failed'], 500);
        }
     }
}
