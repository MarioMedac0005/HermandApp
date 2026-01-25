<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasApiTokens, HasFactory, Notifiable, CanResetPassword, SoftDeletes;

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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function getNavbarAvatarAttribute(): string
    {
        // ADMIN → avatar por defecto
        if ($this->hasRole('admin')) {
            return 'https://ui-avatars.com/api/?name=Administrador&length=2&background=800080&color=ffff00&rounded=true';
        }

        // GESTOR DE BANDA
        if ($this->band && $this->band->profileImage) {
            return $this->band->profileImage->url;
        }

        // GESTOR DE HERMANDAD
        if ($this->brotherhood && $this->brotherhood->profileImage) {
            return $this->brotherhood->profileImage->url;
        }

        // Fallback de seguridad
        return 'https://ui-avatars.com/api/?background=999&color=fff&rounded=true' . urlencode($this->name);
    }

    public function getNavbarOrganizationAttribute(): string
    {
        if ($this->hasRole('admin')) {
            return 'Administrador';
        }

        if ($this->band) {
            return $this->band->name;
        }

        if ($this->brotherhood) {
            return $this->brotherhood->name;
        }

        return '—';
    }

    public function getPanelAttribute(): string|null 
    {
        if ($this->hasRole('admin')) {
            return 'admin';
        }

        if ($this->hasRole('gestor')) {
            if ($this->band) {
                return 'gestor_banda';
            }

            if ($this->brotherhood) {
                return 'gestor_hermandad';
            }
        }

        return null;
    }
}
