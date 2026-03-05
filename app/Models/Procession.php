<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procession extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'distance',
        'points_count',
        'preview_url',
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

    /**
     * Get the segments for the procession.
     */
    public function segments(): HasMany
    {
        return $this->hasMany(Segment::class);
    }

    /**
     * Get the points of interest for the procession.
     */
    public function pointsOfInterest(): HasMany
    {
        return $this->hasMany(PointOfInterest::class);
    }
}
