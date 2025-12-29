<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'path',
        'mime_type',
        'category'
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
