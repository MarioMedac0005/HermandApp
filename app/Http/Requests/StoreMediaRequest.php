<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected array $allowedCategories = [
        'profile',
        'banner',
        'gallery',
        'blog',
        'other'
    ];

    protected array $allowedModels = [
        'band',
        'brotherhood',
        'user'
    ];

    protected array $allowedMimes = [
        'jpg',
        'jpeg',
        'png',
        'webp',
        'gif',
        'mp4',
        'webm',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file'       => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm|max:102400',
            'model_type' => 'required|in:band,brotherhood,user',
            'model_id'   => 'required|integer',
            'category'   => 'required|in:profile,banner,gallery,blog,other',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'El archivo es obligatorio.',
            'file.mimes' => 'El archivo debe ser una imagen o vídeo válido.',

            'model_type.required' => 'Debes indicar el tipo de modelo.',
            'model_type.in' => 'El tipo de modelo no es válido.',

            'model_id.required' => 'Debes indicar el ID del modelo.',

            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría especificada no es válida.',
        ];
    }
}
