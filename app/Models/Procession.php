<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'itinerary',
        'checkout_time',
        'checkin_time',
        'brotherhood_id'
    ];

    /**
     * Obtener la hermandad de una procesión.
     */
    public function brotherhood(): BelongsTo
    {
        return $this->belongsTo(Brotherhood::class);
    }

    /**
     * Obtener los contratos de una procesion.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
