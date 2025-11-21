<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'shift_date',
        'start_time',
        'end_time',
        'shift_type',
        'notes',
        'is_repeating',
        'repeat_frequency',
        'repeat_until'
    ];

    protected $casts = [
        'shift_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_repeating' => 'boolean',
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getDurationAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return $end->diffInHours($start);
    }

    public function getFormattedShiftAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_time)->format('g:i A');
        $end = \Carbon\Carbon::parse($this->end_time)->format('g:i A');
        return "{$start} - {$end}";
    }
}