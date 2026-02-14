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

    protected $fillable = [
        'date',
        'status',
        'amount',
        'description',
        'pdf_path',
        'signed_by_band_at',
        'signed_by_brotherhood_at',
        'band_signed_pdf_path',
        'brotherhood_signed_pdf_path',
        'band_signature_hash',
        'brotherhood_signature_hash',
        'band_id',
        'brotherhood_id',
        'procession_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'signed_by_band_at' => 'datetime',
        'signed_by_brotherhood_at' => 'datetime',
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
}
