<?php
// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'notes',
        'birthday',
        'birth_year',
        'gender',
        'pronouns',
        'client_source',
        'referred_by_client_id',
        'preferred_language',
        'occupation',
        'country',
        'additional_email',
        'additional_phone',
        'email_notifications',
        'text_message_notifications',
        'whatsapp_notifications',
        'email_marketing',
        'text_message_marketing',
        'whatsapp_marketing'
    ];

    protected $casts = [
        'birthday' => 'date',
        'email_notifications' => 'boolean',
        'text_message_notifications' => 'boolean',
        'whatsapp_notifications' => 'boolean',
        'email_marketing' => 'boolean',
        'text_message_marketing' => 'boolean',
        'whatsapp_marketing' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(ClientMembership::class);
    }
    public function activeMemberships(): HasMany
    {
        return $this->hasMany(ClientMembership::class)->active();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(ClientEmergencyContact::class);
    }

    public function referredBy(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'referred_by_client_id');
    }
    public function referredClients(): HasMany
    {
        return $this->hasMany(Client::class, 'referred_by_client_id');
    }

    // Helper method to get full name
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}