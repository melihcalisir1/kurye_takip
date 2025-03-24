<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SirketController extends Controller
{
    public function createKurye(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // ZATEN VARSA → GÜNCELLE
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->role = 'kurye';
            $user->save();

            return response()->json([
                'message' => 'Mevcut kullanıcı kurye olarak güncellendi',
                'user' => $user
            ]);
        }

        // YOKSA → OLUŞTUR
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'kurye'
        ]);

        return response()->json([
            'message' => 'Yeni kurye oluşturuldu',
            'user' => $newUser
        ]);
    }


}
