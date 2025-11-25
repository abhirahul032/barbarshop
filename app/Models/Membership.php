<?php
// app/Models/Membership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'description',
        'color',
        'session_type',
        'session_count',
        'validity_period',
        'validity_duration',
        'price',
        'tax_rate_id',
        'online_sales_enabled',
        'online_redemption_enabled',
        'terms_conditions',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'online_sales_enabled' => 'boolean',
        'online_redemption_enabled' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'membership_services');
    }

    public function taxRate(): BelongsTo
    {
        return $this->belongsTo(TaxRate::class);
    }

    public function clientMemberships(): HasMany
    {
        return $this->hasMany(ClientMembership::class);
    }
}