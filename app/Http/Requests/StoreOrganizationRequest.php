<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\OrganizationRequest;
use Illuminate\Validation\ValidationException;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Registro público
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:band,brotherhood',

            // Usuario
            'user.name' => 'required|string|max:255',
            'user.surname' => 'nullable|string|max:255',
            'user.email' => 'required|email|max:255',

            // Organización (común)
            'organization.name' => 'required|string|max:255',
            'organization.city' => 'required|in:Almeria,Cadiz,Cordoba,Granada,Huelva,Jaen,Malaga,Sevilla',
            'organization.email' => 'required|email|max:255',

            // Hermandad
            'organization.canonicalSeat' => 'required_if:type,brotherhood|string|max:255',
            'organization.phone' => 'required_if:type,brotherhood|string|max:30',

            // Banda
            'organization.description' => 'required_if:type,band|string|max:500',
            'organization.rehearsalPlace' => 'required_if:type,band|string|max:255',
        ];
    }

    protected function passedValidation(): void
    {
        // Evitar solicitudes duplicadas PENDIENTES por email
        $email = $this->input('user.email');

        $exists = OrganizationRequest::where('status', 'pending')
            ->where('payload->user->email', $email)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'user.email' => 'Ya existe una solicitud pendiente con este correo electrónico.',
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'type.required' => 'El tipo de organización es obligatorio.',
            'type.in' => 'El tipo de organización no es válido.',

            'user.name.required' => 'El nombre del usuario es obligatorio.',
            'user.email.required' => 'El correo electrónico es obligatorio.',
            'user.email.email' => 'El correo electrónico no es válido.',

            'organization.name.required' => 'El nombre de la organización es obligatorio.',
            'organization.city.required' => 'La provincia es obligatoria.',
            'organization.city.in' => 'La provincia seleccionada no es válida.',

            'organization.canonicalSeat.required_if' =>
                'La sede canónica es obligatoria para una hermandad.',
            'organization.phone.required_if' =>
                'El teléfono es obligatorio para una hermandad.',

            'organization.description.required_if' =>
                'La descripción es obligatoria para una banda.',
            'organization.rehearsalPlace.required_if' =>
                'El lugar de ensayo es obligatorio para una banda.',
        ];
    }
}
