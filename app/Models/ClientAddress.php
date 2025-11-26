<?php
// app/Models/ClientAddress.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientAddress extends Model
{
    protected $fillable = [
        'client_id',
        'type',
        'address_name',
        'address_line_1',
        'address_line_2',
        'apt_suite',
        'district',
        'city',
        'region',
        'postcode',
        'country',
        'is_primary'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}