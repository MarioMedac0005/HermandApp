<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityRequest extends FormRequest
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
            'date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:free,occupied',
            'description' => 'nullable|string',
            'band_id' => 'required|exists:bands,id',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La fecha es obligatoria.',
            'date.date' => 'La fecha no es válida.',
            'date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser "free" o "occupied".',
            'band_id.required' => 'La banda es obligatoria.',
            'band_id.exists' => 'La banda seleccionada no existe.',
        ];
    }
}
