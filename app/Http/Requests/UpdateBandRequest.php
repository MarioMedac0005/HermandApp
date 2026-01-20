<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:255', Rule::in(['Almería', 'Cádiz', 'Córdoba', 'Granada', 'Huelva', 'Jaén', 'Málaga', 'Sevilla'])],
            'rehearsal_space' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la banda es obligatorio.',
            'name.max' => 'El nombre de la banda no puede tener más de 255 caracteres.',

            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede tener más de 2000 caracteres.',

            'city.string' => 'La ciudad debe ser una cadena de texto.',
            'city.max' => 'El nombre de la ciudad no puede tener más de 255 caracteres.',
            'city.in' => 'La ciudad debe ser una de las siguientes: Almería, Cádiz, Córdoba, Granada, Huelva, Jaén, Málaga, Sevilla, Ceuta, Melilla.',

            'rehearsal_space.string' => 'El espacio de ensayo debe ser una cadena de texto.',
            'rehearsal_space.max' => 'El espacio de ensayo no puede tener más de 255 caracteres.',

            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.max' => 'El email no puede tener más de 255 caracteres.',
        ];
    }
}
