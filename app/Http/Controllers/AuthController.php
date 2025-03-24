<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|unique:users',
            'role' => 'in:kurye,şirket_sahibi,admin,musteri'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        return response()->json([
            'message' => ucfirst($validated['role']) . ' başarıyla oluşturuldu',
            'user' => $user
        ]);
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Hatalı bilgiler'
            ], 401);
        }

        $token = $user->createToken('userToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Çıkış yapıldı']);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
