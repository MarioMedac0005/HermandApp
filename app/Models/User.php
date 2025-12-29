<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'type',
        'band_id',
        'brotherhood_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtener la banda que gestiona un usuario.
     */
    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }

    /**
     * Obtener la hermandad que gestiona un usuario.
     */
    public function brotherhood(): BelongsTo
    {
        return $this->belongsTo(Brotherhood::class);
    }

    /**
     * Relación polimórfica con Media
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }

    // --- OPCIONAL ---

    /**
     * Obtener directamente la foto de perfil del modelo.
     */
    public function profileImage()
    {
        return $this->morphOne(Media::class, 'model')->where('category', 'profile');
    }

    /**
     * Mutator para el atributo "password".
     *
     * Cada vez que se asigne un valor al campo "password" del modelo,
     * Laravel ejecutará automáticamente este método antes de guardar en la base de datos.
     * Esto asegura que la contraseña siempre se guarde en forma de hash seguro.
     *
     * @param string $value La contraseña en texto plano
     */
    protected function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
