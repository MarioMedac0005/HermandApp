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

            // Información básica
            'performance_type' => $this->performance_type,
            'performance_date' => $this->performance_date,
            'approximate_route' => $this->approximate_route,
            'duration' => $this->duration,
            'minimum_musicians' => $this->minimum_musicians,
            'amount' => $this->amount,
            'additional_information' => $this->additional_information,
            'status' => $this->status,

            // PDFs
            'pdf_url' => $this->pdf_path 
                ? asset('storage/' . $this->pdf_path) 
                : null,

            'band_signed_pdf_url' => $this->band_signed_pdf_path 
                ? asset('storage/' . $this->band_signed_pdf_path) 
                : null,

            'brotherhood_signed_pdf_url' => $this->brotherhood_signed_pdf_path 
                ? asset('storage/' . $this->brotherhood_signed_pdf_path) 
                : null,

            // Firmas
            'band_signature_hash' => $this->band_signature_hash,
            'brotherhood_signature_hash' => $this->brotherhood_signature_hash,
            'signed_by_band_at' => $this->signed_by_band_at,
            'signed_by_brotherhood_at' => $this->signed_by_brotherhood_at,

            // Pago (Stripe)
            'stripe_session_id' => $this->stripe_session_id,
            'stripe_payment_intent_id' => $this->stripe_payment_intent_id,
            'paid_at' => $this->paid_at,

            // Relaciones
            'band' => $this->whenLoaded('band'),
            'brotherhood' => $this->whenLoaded('brotherhood'),
            'procession' => $this->whenLoaded('procession'),
            'invoice' => $this->whenLoaded('invoice'),

            // Fechas del sistema
            'created_at' => $this->created_at?->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at?->format('d/m/Y H:i'),
            'deleted_at' => $this->deleted_at?->format('d/m/Y H:i'),
        ];
    }
}
