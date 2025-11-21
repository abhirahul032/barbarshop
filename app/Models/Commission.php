<?php
// app/Models/Commission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'services_commission_enabled',
        'services_commission_type',
        'services_default_rate',
        'services_calculation_type',
        'products_commission_enabled',
        'products_commission_type',
        'products_default_rate',
        'products_calculation_type',
        'memberships_commission_enabled',
        'memberships_commission_type',
        'memberships_default_rate',
        'memberships_calculation_type',
        'memberships_deduct_discounts',
        'memberships_deduct_taxes',
        'gift_cards_commission_enabled',
        'gift_cards_commission_type',
        'gift_cards_default_rate',
        'gift_cards_calculation_type',
        'cancellation_commission_enabled',
        'late_cancellation_fee',
        'no_show_fee',
    ];

    protected $casts = [
        'services_commission_enabled' => 'boolean',
        'products_commission_enabled' => 'boolean',
        'memberships_commission_enabled' => 'boolean',
        'gift_cards_commission_enabled' => 'boolean',
        'cancellation_commission_enabled' => 'boolean',
        'late_cancellation_fee' => 'boolean',
        'no_show_fee' => 'boolean',
        'services_default_rate' => 'decimal:2',
        'products_default_rate' => 'decimal:2',
        'memberships_default_rate' => 'decimal:2',
        'gift_cards_default_rate' => 'decimal:2',
        'memberships_deduct_discounts' => 'boolean',
        'memberships_deduct_taxes' => 'boolean',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function overrides()
    {
        return $this->hasMany(CommissionOverride::class);
    }
}