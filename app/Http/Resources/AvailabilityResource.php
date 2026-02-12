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
            'date' => $this->date,
            'status' => $this->status,
            'description' => $this->description,
            'band' => $this->whenLoaded('band'),
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('d/m/Y H:i') : null,
        ];
    }
}
