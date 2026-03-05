<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointOfInterest extends Model
{
    use HasFactory;

    protected $table = 'points_of_interest';

    protected $fillable = [
        'procession_id',
        'name',
        'description',
        'lat',
        'lng',
        'image_url',
        'icon',
        'color',
        'show_label'
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'show_label' => 'boolean'
    ];

    /**
     * Get the procession that owns the point of interest.
     */
    public function procession(): BelongsTo
    {
        return $this->belongsTo(Procession::class);
    }
}
