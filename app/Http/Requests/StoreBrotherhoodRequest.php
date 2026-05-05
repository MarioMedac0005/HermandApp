<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrotherhoodRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brotherhoods', 'name')->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string|max:2000',
            'city' => 'required|string|max:255',
            'office' => 'required|string|max:255',
            'phone_number' => 'nullable|phone:ES',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('brotherhoods', 'email')->whereNull('deleted_at'),
            ],
            'nazarenes' => 'nullable|integer|min:0|max:10000',
            'year_of_founding' => 'nullable|integer|digits:4|min:1000|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la hermandad es obligatorio.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede tener más de 2000 caracteres.',
            'city.required' => 'La ciudad es obligatoria.',
            'office.required' => 'La oficina es obligatoria.',
            'phone_number.phone' => 'El número de teléfono no es válido.',

            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Ya existe una hermandad con ese email.',

            'nazarenes.integer' => 'El número de nazarenos debe ser un número entero.',
            'nazarenes.min' => 'El número de nazarenos no puede ser negativo.',
            'nazarenes.max' => 'El número de nazarenos es demasiado grande.',

            'year_of_founding.integer' => 'El año de fundación debe ser un número.',
            'year_of_founding.digits' => 'El año de fundación debe tener 4 dígitos.',
            'year_of_founding.min' => 'El año de fundación no es válido.',
            'year_of_founding.max' => 'El año de fundación no puede ser mayor al año actual.',
        ];
    }
}
