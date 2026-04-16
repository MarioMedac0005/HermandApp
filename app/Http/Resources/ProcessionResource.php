<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessionResource extends JsonResource
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
            'type' => $this->type_label,
            'status' => $this->status,
            'distance' => $this->distance,
            'points_count' => $this->points_count,
            'preview_url' => $this->preview_url,
            'checkout_time' => $this->checkout_time,
            'checkin_time' => $this->checkin_time,
            'brotherhood' => [
                'id' => $this->brotherhood_id,
                'name' => $this->brotherhood?->name,
            ],
            'tramos' => SegmentResource::collection($this->whenLoaded('segments')),
            'points' => PointOfInterestResource::collection($this->whenLoaded('pointsOfInterest')),
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),
        ];
    }
}
