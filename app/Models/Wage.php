<?php
// app/Models/Wage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wage extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'compensation_type',
        'hourly_rate',
        'salary_amount',
        'salary_period',
        'overtime_enabled',
        'regular_hours',
        'hours_type',
        'overtime_type',
        'overtime_rate',
        'location_restrictions',
        'timesheet_automation',
        'automated_breaks',
        'auto_check_out',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'salary_amount' => 'decimal:2',
        'overtime_enabled' => 'boolean',
        'regular_hours' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }
}