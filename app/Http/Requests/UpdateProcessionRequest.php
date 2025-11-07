<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcessionRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:christ,virgin'],
            'itinerary' => ['nullable', 'string'],
            'checkout_time' => ['nullable', 'date'],
            'checkin_time' => ['nullable', 'date', 'after:checkout_time'],
            'brotherhood_id' => ['nullable', 'exists:brotherhoods,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser un texto.',
            'type.in' => 'El tipo debe ser "christ" o "virgin".',
            'itinerary.string' => 'El itinerario debe ser un texto.',
            'checkout_time.date' => 'La hora de salida no es válida.',
            'checkin_time.date' => 'La hora de entrada no es válida.',
            'checkin_time.after' => 'La hora de entrada debe ser posterior a la de salida.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',
        ];
    }
}
