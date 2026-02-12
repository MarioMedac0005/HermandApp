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
            'date' => ['required', 'date', 'after:today'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'band_id' => ['required', 'exists:bands,id'],
            'brotherhood_id' => ['required', 'exists:brotherhoods,id'],
            'procession_id' => ['required', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La fecha del contrato es obligatoria.',
            'date.date' => 'La fecha no es válida.',
            'date.after' => 'La fecha debe ser posterior a hoy.',

            'amount.required' => 'El importe es obligatorio.',
            'amount.numeric' => 'El importe debe ser un número.',
            'amount.min' => 'El importe no puede ser negativo.',

            'band_id.required' => 'La banda es obligatoria.',
            'band_id.exists' => 'La banda seleccionada no existe.',

            'brotherhood_id.required' => 'La hermandad es obligatoria.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',

            'procession_id.required' => 'La procesión es obligatoria.',
            'procession_id.exists' => 'La procesión seleccionada no existe.',

            'description.string' => 'La descripción debe ser texto.',
            'description.max' => 'La descripción no puede superar los 2000 caracteres.',
        ];
    }
}
