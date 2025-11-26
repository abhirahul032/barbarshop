<?php
// app/Models/MembershipRedemption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_membership_id',
        'service_id',
        'appointment_id',
        'redeemed_at',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function clientMembership(): BelongsTo
    {
        return $this->belongsTo(ClientMembership::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}