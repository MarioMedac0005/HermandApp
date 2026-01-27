<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Mail\RegistrationLeadMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validación (suave, solo para asegurar estructura)
        $data = $request->validate([
            'orgType' => 'required|in:brotherhood,band',

            'account.firstName' => 'required|string|max:80',
            'account.lastName'  => 'required|string|max:120',
            'account.email'     => 'required|email|max:255',

            'organization' => 'required|array',
            'organization.name' => 'required|string|max:255',
            'organization.city' => 'required|string|max:120',
            'organization.nifCif' => 'required|string|max:30',
            'organization.email'  => 'required|email|max:255',

            // Hermandad (opcionales porque dependen del tipo)
            'organization.canonicalSeat' => 'nullable|string|max:255',
            'organization.phone'         => 'nullable|string|max:30',

            // Banda (opcionales)
            'organization.description'    => 'nullable|string|max:500',
            'organization.rehearsalPlace' => 'nullable|string|max:255',
        ]);

        $to = config('app.registration_inbox');

        Mail::to($to)->send(new RegistrationLeadMail($data));

        return response()->json([
            'message' => 'Datos recibidos y correo enviado correctamente.'
        ], 200);
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
}
