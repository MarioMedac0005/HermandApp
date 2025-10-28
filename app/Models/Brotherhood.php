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

}
