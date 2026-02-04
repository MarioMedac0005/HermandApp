<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationRequestResource extends JsonResource
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
            'type' => $this->type,
            'status' => $this->status,
            'user' => $this->payload['user'] ?? null,
            'organization' => $this->payload['organization'] ?? null,
            'admin_notes' => $this->admin_notes,
            'approved_at' => $this->approved_at,
            'approved_by' => $this->approvedBy?->name,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
