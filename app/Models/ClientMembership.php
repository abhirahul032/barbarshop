<?php
// app/Models/ClientMembership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientMembership extends Model
{
    protected $fillable = [
        'client_id',
        'membership_id',
        'sessions_used',
        'sessions_remaining',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(MembershipRedemption::class);
    }
}