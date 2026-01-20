<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'city' => $this->city,
            'rehearsal_space' => $this->rehearsal_space,
            'email' => $this->email,

            // Incluimos fechas formateadas
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // No se incluye 'deleted_at' porque normalmente no se muestra en la API
            // Si $this->created_at tiene valor, llama a toDateTimeString().
            // Si $this->created_at es null, simplemente devuelve null (sin error).

            'media' => MediaResource::collection(
                $this->whenLoaded('media')
            ),
        ];
    }
}
