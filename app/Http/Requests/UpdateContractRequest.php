<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'status' => ['nullable', 'in:expired,pending,active'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'band_id' => ['nullable', 'exists:bands,id'],
            'procession_id' => ['nullable', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.date' => 'La fecha no es válida.',
            'date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'status.in' => 'El estado debe ser "expired", "pending" o "active".',
            'amount.numeric' => 'El monto debe ser un número.',
            'amount.min' => 'El monto no puede ser negativo.',
            'band_id.exists' => 'La banda seleccionada no existe.',
            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
