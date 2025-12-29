<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brotherhood extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'office',
        'phone_number',
        'email'
    ];

    /**
     * Obtener los usuarios de una hermandad.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtener las procesiones de una hermandad.
     */
    public function processions(): HasMany
    {
        return $this->hasMany(Procession::class);
    }

    /**
     * Relación polimórfica con Media
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    // --- OPCIONALES ---

    /**
     * Obtener directamente la foto de perfil del modelo.
     */
    public function profileImage()
    {
        return $this->morphOne(Media::class, 'model')->where('category', 'profile');
    }

    /**
     * Obtener portada/cabecera de la hermandad.
     */
    public function banner()
    {
        return $this->morphOne(Media::class, 'model')->where('category', 'banner');
    }

    /**
     * Obtener todas las imágenes de la categoría "gallery".
     */
    public function gallery()
    {
        return $this->morphMany(Media::class, 'model')->where('category', 'gallery');
    }
}
