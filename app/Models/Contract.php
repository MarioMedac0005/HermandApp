<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'status',
        'amount',
        'description',
        'band_id',
        'procession_id'
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
}
