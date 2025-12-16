<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrotherhoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'office' => $this->office,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'deleted_at' => $this->deleted_at?->toDateTimeString(),

            // No se incluye 'deleted_at' porque normalmente no se muestra en la API
            // Si $this->created_at tiene valor, llama a toDateTimeString().
            // Si $this->created_at es null, simplemente devuelve null (sin error).
        ];
    }
}
