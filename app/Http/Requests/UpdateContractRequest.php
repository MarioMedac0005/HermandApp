<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContractRequest extends FormRequest
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
            'date' => ['sometimes', 'date', 'after:today'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'description' => ['sometimes', 'string', 'max:2000'],
            'procession_id' => ['sometimes', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.date' => 'La fecha no es válida.',
            'date.after' => 'La fecha debe ser posterior a hoy.',

            'amount.numeric' => 'El importe debe ser un número.',
            'amount.min' => 'El importe no puede ser negativo.',

            'description.string' => 'La descripción debe ser texto.',
            'description.max' => 'La descripción no puede superar los 2000 caracteres.',

            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
