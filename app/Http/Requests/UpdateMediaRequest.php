<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
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
            'file'       => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm',
            'model_type' => 'nullable|in:band,brotherhood,user',
            'model_id'   => 'nullable|integer',
            'category'   => 'nullable|in:profile,banner,gallery,blog,other',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'El archivo debe ser una imagen o vídeo válido.',

            'model_type.in' => 'El tipo de modelo no es válido.',

            'category.in' => 'La categoría especificada no es válida.',
        ];
    }
}
