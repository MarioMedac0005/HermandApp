<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Band extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'rehearsal_space',
        'email'
    ];

    /**
     * Obtener los usuarios de una banda.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtener los contratos de una banda.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Obtener las disponibilidades de una banda.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
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
     * Obtener portada/cabecera de la banda.
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
