<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContractRequest extends FormRequest
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
            'date' => ['required', 'date'],

            'status' => [
                'nullable',
                Rule::in(['expired', 'pending', 'active']),
            ],

            'amount' => ['nullable', 'numeric', 'min:0'],

            'description' => ['nullable', 'string'],

            'band_id' => ['required', 'exists:bands,id'],

            'procession_id' => ['required', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La fecha del contrato es obligatoria.',
            'date.date' => 'La fecha del contrato no es válida.',

            'status.in' => 'El estado debe ser: pendiente, activo o expirado.',

            'amount.numeric' => 'El importe debe ser un número.',
            'amount.min' => 'El importe no puede ser negativo.',

            'band_id.required' => 'La banda es obligatoria.',
            'band_id.exists' => 'La banda seleccionada no existe.',

            'procession_id.required' => 'La procesión es obligatoria.',
            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
