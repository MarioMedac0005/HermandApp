<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'type' => ['required', 'in:band_admin,brotherhood_admin,guest'],
            'band_id' => ['required', 'exists:bands,id'],
            'brotherhood_id' => ['required', 'exists:brotherhoods,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'type.required' => 'El tipo de usuario es obligatorio.',
            'type.in' => 'El tipo de usuario debe ser uno de: band_admin, brotherhood_admin o guest.',
            'band_id.required' => 'El campo band_id es obligatorio.',
            'band_id.exists' => 'La banda seleccionada no existe.',
            'brotherhood_id.required' => 'El campo brotherhood_id es obligatorio.',
            'brotherhood_id.exists' => 'La hermandad seleccionada no existe.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
