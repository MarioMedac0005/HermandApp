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
            'performance_type' => [
                'required',
                Rule::in(['procession', 'concert', 'transfer', 'festival', 'other']),
            ],

            'performance_date' => ['required', 'date'],

            'approximate_route' => ['nullable', 'string'],

            'duration' => ['required', 'integer', 'min:1'],

            'minimum_musicians' => ['required', 'integer', 'min:1'],

            'amount' => ['nullable', 'numeric', 'min:0'],

            'additional_information' => ['nullable', 'string'],

            'band_id' => ['required', 'exists:bands,id'],

            'brotherhood_id' => ['required', 'exists:brotherhoods,id'],

            'procession_id' => ['exists:processions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'performance_type.required' => 'El tipo de actuación es obligatorio.',
            'performance_type.in' => 'El tipo de actuación no es válido.',

            'performance_date.required' => 'La fecha de la actuación es obligatoria.',
            'performance_date.date' => 'La fecha de la actuación no es válida.',

            'duration.required' => 'La duración es obligatoria.',
            'duration.integer' => 'La duración debe ser un número entero.',
            'duration.min' => 'La duración debe ser mayor que 0.',

            'minimum_musicians.required' => 'El número mínimo de músicos es obligatorio.',
            'minimum_musicians.integer' => 'El número mínimo de músicos debe ser un número entero.',
            'minimum_musicians.min' => 'Debe haber al menos un músico.',

            'amount.numeric' => 'El importe debe ser un número.',
            'amount.min' => 'El importe no puede ser negativo.',

            'band_id.required' => 'La banda es obligatoria.',
            'band_id.exists' => 'La banda seleccionada no existe.',

            'brotherhood_id.required' => 'La hermandad es obligatoria.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',

            'procession_id.required' => 'La procesión es obligatoria.',
            'procession_id.exists' => 'La procesión seleccionada no existe.',
        ];
    }
}
