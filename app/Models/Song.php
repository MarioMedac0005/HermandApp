<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'duration',
        'url',
        'band_id',
    ];

    public function band()
    {
        return $this->belongsTo(Band::class);
    }
}
