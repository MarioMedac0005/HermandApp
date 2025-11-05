<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('access_token')->plainTextToken
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('access_token')->plainTextToken
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
