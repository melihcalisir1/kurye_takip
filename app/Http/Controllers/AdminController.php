<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createSirketSahibi(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'şirket_sahibi',
        ]);

        return response()->json([
            'message' => 'Şirket Sahibi oluşturuldu',
            'user' => $user
        ], 201);
    }
}
