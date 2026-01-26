<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

    public function addGestor(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'band_id' => 'nullable|exists:bands,id|required_without:brotherhood_id',
            'brotherhood_id' => 'nullable|exists:hermandades,id|required_without:band_id',
        ]);

        if ($request->filled('band_id') && $request->filled('brotherhood_id')) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede crear un gestor con bandas y hermandades',
            ], 400);
        }

        $gestor = null;

        DB::transaction(function () use ($request, &$gestor) {
            $gestor = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(16)),
                'band_id' => $request->band_id,
                'brotherhood_id' => $request->brotherhood_id,
            ]);

            $gestor->assignRole('gestor');
        });

        // 👇 AÑADIDO
        $mailSent = true;

        try {
            $status = Password::broker()->sendResetLink(
                $request->only('email')
            );

            if ($status !== Password::RESET_LINK_SENT) {
                $mailSent = false;
            }
        } catch (\Throwable $e) {
            $mailSent = false;

            Log::error('Error enviando email de reset', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'mail_sent' => $mailSent,
            'message' => $mailSent
                ? 'Gestor creado y email enviado'
                : 'Gestor creado, pero el email NO pudo enviarse',
        ], 201);
    }



}
