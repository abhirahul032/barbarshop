<?php
// app/Models/PayRun.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'preferred_payment_method',
        'pay_calculation',
        'deduct_processing_fees',
        'deduct_client_fees',
        'processing_fee_percentage',
        'client_fee_percentage',
        'record_cash_advances',
        'auto_record_cash_payments',
        'pay_frequency',
        'pay_schedule',
        'next_pay_date',
        'include_commissions',
        'include_tips',
        'include_bonuses',
        'auto_generate_pay_runs',
    ];

    protected $casts = [
        'deduct_processing_fees' => 'boolean',
        'deduct_client_fees' => 'boolean',
        'record_cash_advances' => 'boolean',
        'auto_record_cash_payments' => 'boolean',
        'include_commissions' => 'boolean',
        'include_tips' => 'boolean',
        'include_bonuses' => 'boolean',
        'auto_generate_pay_runs' => 'boolean',
        'processing_fee_percentage' => 'decimal:2',
        'client_fee_percentage' => 'decimal:2',
        'next_pay_date' => 'date',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function payRunHistory()
    {
        return $this->hasMany(PayRunHistory::class);
    }
}