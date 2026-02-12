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
            'date' => $this->date,
            'status' => $this->status,
            'amount' => $this->amount,
            'description' => $this->description,
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
