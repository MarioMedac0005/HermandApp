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
            'description' => $this->description,
            'city' => $this->city,
            'office' => $this->office,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'nazarenes' => $this->nazarenes,
            'year_of_founding' => $this->year_of_founding,
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),

            'media' => MediaResource::collection(
                $this->whenLoaded('media')
            ),
        ];
    }
}
