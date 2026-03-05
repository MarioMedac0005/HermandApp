<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'procession_id',
        'name',
        'color',
        'width',
        'visible',
        'coordinates'
    ];

    protected $casts = [
        'coordinates' => 'json',
        'visible' => 'boolean',
        'width' => 'integer'
    ];

    /**
     * Get the procession that owns the segment.
     */
    public function procession(): BelongsTo
    {
        return $this->belongsTo(Procession::class);
    }
}
