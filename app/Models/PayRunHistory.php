<?php
// app/Models/PayRunHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRunHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'pay_period_start',
        'pay_period_end',
        'pay_date',
        'total_earnings',
        'base_wages',
        'overtime_wages',
        'commissions',
        'tips',
        'bonuses',
        'deductions',
        'processing_fees',
        'client_fees',
        'net_pay',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'pay_period_start' => 'date',
        'pay_period_end' => 'date',
        'pay_date' => 'date',
        'total_earnings' => 'decimal:2',
        'base_wages' => 'decimal:2',
        'overtime_wages' => 'decimal:2',
        'commissions' => 'decimal:2',
        'tips' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'deductions' => 'decimal:2',
        'processing_fees' => 'decimal:2',
        'client_fees' => 'decimal:2',
        'net_pay' => 'decimal:2',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function deductions()
    {
        return $this->hasMany(PayRunDeduction::class);
    }
}