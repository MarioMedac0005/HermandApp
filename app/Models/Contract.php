<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    use HasFactory;

    const STATUS_COMPLETED = 'completed';
    const STATUS_PAID = 'paid';

    protected $fillable = [
        'performance_type',
        'performance_date',
        'approximate_route',
        'duration',
        'minimum_musicians',
        'amount',
        'additional_information',
        'status',
        'pdf_path',
        'signed_by_band_at',
        'signed_by_brotherhood_at',
        'band_signed_pdf_path',
        'brotherhood_signed_pdf_path',
        'band_signature_hash',
        'brotherhood_signature_hash',
        'stripe_payment_intent_id',
        'paid_at',
        'band_id',
        'brotherhood_id',
        'procession_id'
    ];

    protected $casts = [
        'performance_date' => 'date',
        'signed_by_band_at' => 'datetime',
        'signed_by_brotherhood_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Obtener la procesion de un contrato.
     */
    public function procession(): BelongsTo
    {
        return $this->belongsTo(Procession::class);

    }

    /**
     * Obtener la banda de un contrato.
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    /**
     * Obtener la hermandad de un contrato.
     */
    public function brotherhood(): BelongsTo
    {
        return $this->belongsTo(Brotherhood::class);
    }

    /**
     * Obtener la factura de un contrato.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

}
