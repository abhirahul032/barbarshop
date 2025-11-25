<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'additional_phone_number',
        'birthday',
        'country',
        'job_title',
        'visible_to_clients',
        'start_date',
        'end_date',
        'employment_type',
        'team_member_id',
        'notes',
        'calendar_color',
        'rating',
        'review_count',
        'is_active',
        'profile_picture',
        'permission_level',
        'allow_bookings'
    ];

    protected $casts = [
        'birthday' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'visible_to_clients' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    // In TeamMember.php
    public function scheduledShifts(): HasMany
    {
        return $this->hasMany(ScheduledShift::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
     // Add this relationship
    public function payRun()
    {
        return $this->hasOne(PayRun::class);
    }

    public function payRunHistory()
    {
        return $this->hasMany(PayRunHistory::class);
    }

    // Add this relationship
    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }
     // Add this relationship
    public function wage()
    {
        return $this->hasOne(Wage::class);
    }
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'team_member_services');
    }

    public function locations()
    {
        return $this->belongsToMany(Store::class, 'team_member_locations');
    }

     public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRatingDisplayAttribute()
    {
        return $this->review_count > 0 ? number_format($this->rating, 1) . ' (' . $this->review_count . ' reviews)' : 'No reviews yet';
    }
    /*
    public function isAvailableAt($date, $startTime, $endTime): bool
    {
        // Check if team member has a shift on this date
        $shift = $this->scheduledShifts()
            ->where('shift_date', $date)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->first();

        if (!$shift) {
            return false;
        }

        // Check for overlapping appointments
        $overlappingAppointment = $this->appointments()
            ->where('appointment_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->exists();

        return !$overlappingAppointment;
    }*/
    
    // Add this method to your TeamMember model
public function isAvailableAt($date, $startTime, $endTime, $excludeAppointmentId = null): bool
{
    // Check if team member has a shift on this date
    $shift = $this->scheduledShifts()
        ->where('shift_date', $date)
        ->where('start_time', '<=', $startTime)
        ->where('end_time', '>=', $endTime)
        ->first();

    if (!$shift) {
        return false;
    }

    // Check for overlapping appointments
    $query = $this->appointments()
        ->where('appointment_date', $date)
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                ->orWhereBetween('end_time', [$startTime, $endTime])
                ->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
        })
        ->whereIn('status', ['scheduled', 'confirmed']);

    if ($excludeAppointmentId) {
        $query->where('id', '!=', $excludeAppointmentId);
    }

    return !$query->exists();
}
    
    public function getAvailableSlots($date, $duration): array
    {
        $slots = [];
        $shift = $this->scheduledShifts()
            ->where('shift_date', $date)
            ->first();

        if (!$shift) {
            return $slots;
        }

        $start = \Carbon\Carbon::parse($shift->start_time);
        $end = \Carbon\Carbon::parse($shift->end_time);
        $interval = \Carbon\CarbonInterval::minutes(15); // 15-minute intervals

        $current = $start->copy();
        
        while ($current->addMinutes($duration) <= $end) {
            $slotStart = $current->copy()->subMinutes($duration);
            $slotEnd = $current->copy();
            
            if ($this->isAvailableAt($date, $slotStart->format('H:i:s'), $slotEnd->format('H:i:s'))) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'formatted' => $slotStart->format('g:i A') . ' - ' . $slotEnd->format('g:i A')
                ];
            }
        }

        return $slots;
    }
    
}