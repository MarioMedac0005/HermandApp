<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'type' => $this->type,
            'band_id' => $this->band_id,
            'brotherhood_id' => $this->brotherhood_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relaciones opcionales, si existen:
            'band' => new BandResource($this->whenLoaded('band')),
            'brotherhood' => new BrotherhoodResource($this->whenLoaded('brotherhood')),
            'role' => $this->getRoleNames()->first(),
        ];
    }
}
