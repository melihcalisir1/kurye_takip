<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Giriş başarılı',
                'token' => $token,
                'role' => $user->role,
                'user' => $user
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Geçersiz e-posta veya şifre'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Çıkış başarılı'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
} 