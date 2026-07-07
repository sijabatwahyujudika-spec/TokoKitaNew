<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Login gagal! Email atau password salah.',
            ], 401);
        }

        $token = $user->createToken('token_aplikasi_mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'data_user' => $user->name,
            'token' => $token,
        ], 200);
    }
}