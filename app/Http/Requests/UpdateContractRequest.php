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
            'date' => ['nullable', 'date', 'after_or_equal:today'],
            'status' => ['nullable', Rule::in(['expired', 'pending', 'active'])],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'band_id' => ['nullable', 'exists:bands,id'],
            'procession_id' => ['nullable', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.date' => 'La fecha no es válida.',
            'date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'status.in' => 'El estado debe ser uno de los siguientes: "expired", "pending" o "active".',
            'amount.numeric' => 'El monto debe ser un número.',
            'amount.min' => 'El monto no puede ser negativo.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede tener más de 2000 caracteres.',
            'band_id.exists' => 'La banda seleccionada no existe.',
            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
