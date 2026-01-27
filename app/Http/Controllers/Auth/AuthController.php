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
        $data = $request->validate([
            'orgType' => 'required|in:brotherhood,band',

            // Cuenta
            'account.firstName' => 'required|string|min:2|max:80',
            'account.lastName'  => 'required|string|min:2|max:120',
            'account.email'     => 'required|email|max:255',

            // Organización
            'organization' => 'required|array',
            'organization.name' => 'required|string|min:2|max:255',
            'organization.city' => 'required|string|min:2|max:120',
            'organization.nifCif' => [
                'required',
                'regex:/^([A-HJ-NP-SUVW]\d{7}[0-9A-J]|[0-9]{8}[A-Z])$/i'
            ],
            'organization.email'  => 'required|email|max:255',

            // Hermandad (solo si orgType = brotherhood)
            'organization.canonicalSeat' => 'required_if:orgType,brotherhood|string|max:255',
            'organization.phone'         => 'required_if:orgType,brotherhood|string|max:30',

            // Banda (solo si orgType = band)
            'organization.description'    => 'required_if:orgType,band|string|max:500',
            'organization.rehearsalPlace' => 'required_if:orgType,band|string|max:255',
        ], [
            // Mensajes personalizados
            'orgType.in' => 'El tipo de organización no es válido.',

            'organization.canonicalSeat.required_if' =>
                'La sede canónica es obligatoria para una hermandad.',
            'organization.phone.required_if' =>
                'El teléfono es obligatorio para una hermandad.',

            'organization.description.required_if' =>
                'La descripción es obligatoria para una banda.',
            'organization.rehearsalPlace.required_if' =>
                'El lugar de ensayo es obligatorio para una banda.',
        ]);

        // Traducción del tipo
        $orgTypes = [
            'band' => 'Banda',
            'brotherhood' => 'Hermandad',
        ];

        $data['orgTypeLabel'] = $orgTypes[$data['orgType']];

        Mail::to('support@23arenadaw.com.es')
            ->send(new RegistrationLeadMail($data));

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
