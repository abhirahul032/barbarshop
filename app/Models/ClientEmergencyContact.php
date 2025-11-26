<?php
// app/Models/ClientEmergencyContact.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientEmergencyContact extends Model
{
    protected $fillable = [
        'client_id',
        'full_name',
        'email',
        'phone',
        'relationship',
        'is_primary'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}