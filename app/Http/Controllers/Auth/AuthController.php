<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrganizationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthUserResource;
use App\Http\Requests\StoreOrganizationRequest;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(StoreOrganizationRequest $request)
    {
        OrganizationRequest::create([
            'type' => $request->input('type'),
            'payload' => [
                'user' => $request->input('user'),
                'organization' => $request->input('organization'),
            ],
        ]);

        return response()->json([
            'message' => 'Tu solicitud ha sido enviada. Un administrador la revisará en breve.'
        ], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->load('band');

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'user' => new AuthUserResource($user),
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
