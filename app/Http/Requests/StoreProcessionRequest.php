<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Decode JSON strings into arrays when coming from FormData
        $merge = [];

        if (is_string($this->tramos)) {
            $merge['tramos'] = json_decode($this->tramos, true);
        }

        if (is_string($this->points)) {
            $merge['points'] = json_decode($this->points, true);
        }

        if (!empty($merge)) {
            $this->merge($merge);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:christ,virgin,other',
            'status' => 'nullable|in:draft,published',
            'distance' => 'nullable|numeric',
            'points_count' => 'nullable|integer',
            'preview_url' => 'nullable|string|url',
            'preview' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'checkout_time' => ['nullable', 'date'],
            'checkin_time' => ['nullable', 'date'],
            'brotherhood_id' => 'required|exists:brotherhoods,id',
            'tramos' => 'nullable|array',
            'tramos.*.name' => 'required|string',
            'tramos.*.color' => 'nullable|string',
            'tramos.*.width' => 'nullable|integer',
            'tramos.*.visible' => 'nullable|boolean',
            'tramos.*.coordinates' => 'nullable|array',
            'points' => 'nullable|array',
            'points.*.name' => 'required|string',
            'points.*.description' => 'nullable|string',
            'points.*.lat' => 'required|numeric',
            'points.*.lng' => 'required|numeric',
            'points.*.image_url' => 'nullable|string',
            'points.*.icon' => 'nullable|string',
            'points.*.color' => 'nullable|string',
            'points.*.show_label' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la procesión es obligatorio.',
            'type.required' => 'El tipo de procesión es obligatorio.',
            'type.in' => 'El tipo debe ser "christ", "virgin" u "other".',
            'checkout_time.required' => 'La hora de salida es obligatoria.',
            'checkin_time.required' => 'La hora de entrada es obligatoria.',
            'brotherhood_id.required' => 'La hermandad es obligatoria.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',
            'tramos.*.name.required' => 'El nombre de cada tramo es obligatorio.',
            'points.*.name.required' => 'El nombre de cada punto de interés es obligatorio.',
            'points.*.lat.required' => 'La latitud es obligatoria para los puntos.',
            'points.*.lng.required' => 'La longitud es obligatoria para los puntos.',
        ];
    }
}
