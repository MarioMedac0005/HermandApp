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
            'stripe_account_id' => $this->stripe_account_id,
            'stripe_onboarding_completed' => $this->stripe_onboarding_completed,

            // Incluimos fechas formateadas
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),

            'media' => MediaResource::collection(
                $this->whenLoaded('media')
            ),
            'songs' => SongResource::collection(
                $this->whenLoaded('songs')
            ),
        ];
    }
}
