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
use App\Http\Requests\ActivateAccountRequest;
use App\Http\Requests\StoreOrganizationRequest;

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

    public function activate(ActivateAccountRequest $request, string $token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'El enlace de activación no es válido.'
            ], 404);
        }

        if ($user->activation_token_expires_at && $user->activation_token_expires_at->isPast()) {
            return response()->json([
                'message' => 'El enlace de activación ha expirado.'
            ], 410);
        }

        DB::transaction(function () use ($user, $request) {
            $user->update([
                'password' => Hash::make($request->password),
                'activation_token' => null,
                'activation_token_expires_at' => null,
            ]);
        });

        return response()->json([
            'message' => 'Cuenta activada correctamente. Ya puedes iniciar sesión.'
        ]);
    }
}
