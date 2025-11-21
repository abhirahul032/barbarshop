<?php
// app/Models/CommissionOverride.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionOverride extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'type',
        'item_id',
        'commission_type',
        'rate',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }
}