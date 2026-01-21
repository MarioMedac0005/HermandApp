<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        'date' => 'required|date',
        'amount' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'band_id' => 'required|exists:bands,id',
        'procession_id' => 'required|exists:processions,id',
        // brotherhood_id NO lo pidas al cliente (lo forzamos en backend)
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la procesión es obligatorio.',
            'type.required' => 'El tipo de procesión es obligatorio.',
            'type.in' => 'El tipo debe ser "christ" o "virgin".',
            'itinerary.required' => 'El itinerario es obligatorio.',
            'checkout_time.required' => 'La hora de salida es obligatoria.',
            'checkout_time.before' => 'La hora de salida debe ser anterior a la hora de entrada.',
            'checkin_time.required' => 'La hora de entrada es obligatoria.',
            'checkin_time.after' => 'La hora de entrada debe ser posterior a la hora de salida.',
            'brotherhood_id.required' => 'La hermandad es obligatoria.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',
        ];
    }
}
