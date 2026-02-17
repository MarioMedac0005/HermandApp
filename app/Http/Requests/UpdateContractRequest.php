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
            'performance_type' => [
                'sometimes',
                Rule::in(['procession', 'concert', 'transfer', 'festival', 'other']),
            ],

            'performance_date' => ['sometimes', 'date'],

            'approximate_route' => ['nullable', 'string'],

            'duration' => ['sometimes', 'integer', 'min:1'],

            'minimum_musicians' => ['sometimes', 'integer', 'min:1'],

            'amount' => ['sometimes', 'numeric', 'min:0'],

            'additional_information' => ['nullable', 'string'],

            'status' => [
                'sometimes',
                Rule::in([
                    'pending',
                    'rejected',
                    'accepted',
                    'signed_by_band',
                    'signed_by_brotherhood',
                    'completed',
                    'paid',
                    'payment_failed',
                    'expired',
                ]),
            ],

            'procession_id' => ['sometimes', 'exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'performance_type.in' => 'El tipo de actuación no es válido.',

            'performance_date.date' => 'La fecha de la actuación no es válida.',

            'duration.integer' => 'La duración debe ser un número entero.',
            'duration.min' => 'La duración debe ser mayor que 0.',

            'minimum_musicians.integer' => 'El número mínimo de músicos debe ser un número entero.',
            'minimum_musicians.min' => 'Debe haber al menos un músico.',

            'amount.numeric' => 'El importe debe ser un número.',
            'amount.min' => 'El importe no puede ser negativo.',

            'status.in' => 'El estado del contrato no es válido.',

            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
