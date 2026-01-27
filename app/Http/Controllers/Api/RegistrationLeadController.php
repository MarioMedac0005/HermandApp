<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationLeadMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationLeadController extends Controller
{
    public function store(Request $request)
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
}
