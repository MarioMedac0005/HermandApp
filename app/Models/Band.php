<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Band extends Model
{
    use SoftDeletes;

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
}

