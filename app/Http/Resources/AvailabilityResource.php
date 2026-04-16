<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
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
            'date' => $this->date?->format('d/m/Y'),
            'description' => $this->description,
            'band' => [
                'id' => $this->band_id,
                'name' => $this->band?->name,
            ],
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),
            'deleted_at' => $this->deleted_at?->format('d/m/Y H:i'),
        ];
    }
}
