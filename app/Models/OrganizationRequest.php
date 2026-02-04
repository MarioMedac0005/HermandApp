<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'payload',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'approved_at' => 'datetime',
    ];

    /* Relaciones */

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* Scopes */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
