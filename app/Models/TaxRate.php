<?php
// app/Models/TaxRate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxRate extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'rate',
        'is_default'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_default' => 'boolean'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}