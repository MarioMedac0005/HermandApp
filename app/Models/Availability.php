<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'status',
        'description',
        'band_id'
    ];

    /**
     * Obtener la banda de una disponibilidad.
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
}
