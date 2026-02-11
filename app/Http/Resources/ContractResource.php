<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'date' => $this->date ? $this->date->format('d/m/Y H:i') : null,
            'status' => $this->status,
            'amount' => $this->amount,
            'description' => $this->description,
            'band_id' => $this->band_id,
            'brotherhood_id' => $this->brotherhood_id,
            'procession_id' => $this->procession_id,
            'pdf_path' => $this->pdf_path ? asset('storage/' . $this->pdf_path) : null, // URL pública del PDF
            'band' => $this->whenLoaded('band'), // Puedes usar BandResource si quieres más detalle
            'brotherhood' => $this->whenLoaded('brotherhood'),
            'procession' => $this->whenLoaded('procession'),
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format('d/m/Y H:i') : null,
        ];
    }
}
