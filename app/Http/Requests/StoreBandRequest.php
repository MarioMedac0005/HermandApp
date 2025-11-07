<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBandRequest extends FormRequest
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
            'name' => 'required|string|unique:bands,name|max:255',
            'city' => 'nullable|string|max:255',
            'rehearsal_space' => 'nullable|string|max:255',
            'email' => 'required|email|unique:bands,email|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la banda es obligatorio.',
            'name.unique' => 'Ya existe una banda con ese nombre.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Ya existe una banda con ese email.',
        ];
    }
}
