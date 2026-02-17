<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'contract_id',
        'number',
        'amount',
        'commission_amount',
        'issued_at'
    ];

    protected $dates = [
        'issued_at'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
