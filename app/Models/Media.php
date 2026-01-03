<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'path',
        'mime_type',
        'category'
    ];

    /**
     * Añade automáticamente el atributo "url"
     */
    protected $appends = ['url'];

    public function model()
    {
        return $this->morphTo();
    }

    /**
     * URL pública absoluta del archivo
     */
    public function getUrlAttribute(): string
    {
        return URL::to(Storage::url($this->path));
    }
}
