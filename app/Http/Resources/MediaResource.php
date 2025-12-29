<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'model_type' => class_basename($this->model_type),
            'model_id'   => $this->model_id,
            'category'   => $this->category,
            'mime_type'  => $this->mime_type,
            'path'       => $this->path,
            'url'        => $this->path ? asset('storage/' . $this->path) : null,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
