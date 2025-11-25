<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

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
        'allow_bookings',
        'remember_token',
        'email_verified_at'
    ];

    protected $casts = [
        'birthday' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'visible_to_clients' => 'boolean',
        'is_active' => 'boolean',
        'allow_bookings' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'full_name',
        'rating_display',
        'is_available_today',
        'upcoming_appointments_count'
    ];

    // ============ RELATIONSHIPS ============

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function scheduledShifts(): HasMany
    {
        return $this->hasMany(ScheduledShift::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }

    public function wage(): HasOne
    {
        return $this->hasOne(Wage::class);
    }

    public function payRun(): HasOne
    {
        return $this->hasOne(PayRun::class);
    }

    public function payRunHistory(): HasMany
    {
        return $this->hasMany(PayRunHistory::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'team_member_services');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'team_member_locations');
    }

    public function commissionOverrides(): HasMany
    {
        return $this->hasMany(CommissionOverride::class);
    }

    // ============ ATTRIBUTES ============

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRatingDisplayAttribute(): string
    {
        return $this->review_count > 0 
            ? number_format($this->rating, 1) . ' (' . $this->review_count . ' reviews)' 
            : 'No reviews yet';
    }

    public function getIsAvailableTodayAttribute(): bool
    {
        return $this->isAvailableForDate(Carbon::today());
    }

    public function getUpcomingAppointmentsCountAttribute(): int
    {
        return $this->appointments()
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->count();
    }

    public function getProfilePictureUrlAttribute(): ?string
    {
        if (!$this->profile_picture) {
            return null;
        }

        return asset('storage/' . $this->profile_picture);
    }

    public function getCurrentShiftAttribute(): ?ScheduledShift
    {
        return $this->scheduledShifts()
            ->where('shift_date', Carbon::today())
            ->where('start_time', '<=', Carbon::now()->format('H:i:s'))
            ->where('end_time', '>=', Carbon::now()->format('H:i:s'))
            ->first();
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCanBookAppointments($query)
    {
        return $query->where('is_active', true)
                    ->where('allow_bookings', true);
    }

    public function scopeWithUpcomingAppointments($query)
    {
        return $query->whereHas('appointments', function ($q) {
            $q->where('appointment_date', '>=', Carbon::today())
              ->whereIn('status', ['scheduled', 'confirmed']);
        });
    }

    public function scopeAvailableOnDate($query, $date)
    {
        return $query->whereHas('scheduledShifts', function ($q) use ($date) {
            $q->where('shift_date', $date);
        });
    }

    // ============ AVAILABILITY METHODS ============

    public function isAvailableAt($date, $startTime, $endTime, $excludeAppointmentId = null): bool
    {
        // Check if team member is active and allows bookings
        if (!$this->is_active || !$this->allow_bookings) {
            return false;
        }

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

    public function getAvailableSlots($date, $duration, $interval = 15): array
    {
        $slots = [];
        $shift = $this->scheduledShifts()
            ->where('shift_date', $date)
            ->first();

        if (!$shift) {
            return $slots;
        }

        $start = Carbon::parse($shift->start_time);
        $end = Carbon::parse($shift->end_time);

        $current = $start->copy();
        
        while ($current->addMinutes($duration) <= $end) {
            $slotStart = $current->copy()->subMinutes($duration);
            $slotEnd = $current->copy();
            
            if ($this->isAvailableAt($date, $slotStart->format('H:i:s'), $slotEnd->format('H:i:s'))) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'start_time' => $slotStart->format('H:i:s'),
                    'end_time' => $slotEnd->format('H:i:s'),
                    'formatted' => $slotStart->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                    'duration' => $duration
                ];
            }
            
            // Move to next potential slot based on interval
            $current = $slotStart->copy()->addMinutes($interval);
        }

        return $slots;
    }

    public function isAvailableForDate($date): bool
    {
        return $this->scheduledShifts()
            ->where('shift_date', $date)
            ->exists();
    }

    public function getScheduleForDate($date): array
    {
        $shift = $this->scheduledShifts()
            ->where('shift_date', $date)
            ->first();

        $appointments = $this->appointments()
            ->with('service')
            ->where('appointment_date', $date)
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->orderBy('start_time')
            ->get();

        return [
            'shift' => $shift,
            'appointments' => $appointments,
            'available_slots' => $shift ? $this->getAvailableSlots($date, 60) : [] // Default 60 min slots
        ];
    }

    public function getWeeklySchedule($startDate = null): array
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::today();
        $endDate = $startDate->copy()->addDays(6);

        $schedule = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $schedule[$currentDate->format('Y-m-d')] = $this->getScheduleForDate($currentDate);
            $currentDate->addDay();
        }

        return $schedule;
    }

    // ============ APPOINTMENT METHODS ============

    public function hasAppointmentAt($date, $startTime, $endTime): bool
    {
        return $this->appointments()
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
    }

    public function getTodaysAppointments()
    {
        return $this->appointments()
            ->with('service')
            ->where('appointment_date', Carbon::today())
            ->orderBy('start_time')
            ->get();
    }

    public function getUpcomingAppointments($limit = 5)
    {
        return $this->appointments()
            ->with('service')
            ->where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->limit($limit)
            ->get();
    }

    // ============ COMMISSION METHODS ============

    public function calculateCommissionForAppointment(Appointment $appointment): float
    {
        if (!$this->commission || !$this->commission->services_commission_enabled) {
            return 0;
        }

        $rate = $this->commission->services_default_rate;
        
        // Check for service-specific override
        $override = $this->commission->overrides()
            ->where('type', 'service')
            ->where('item_id', $appointment->service_id)
            ->first();

        if ($override) {
            $rate = $override->rate;
        }

        return $this->commission->services_commission_type === 'percentage' 
            ? ($appointment->price * $rate / 100)
            : $rate;
    }

    public function getTotalCommission($startDate = null, $endDate = null): float
    {
        $query = $this->appointments()
            ->whereIn('status', ['completed']);

        if ($startDate) {
            $query->where('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('appointment_date', '<=', $endDate);
        }

        return $query->sum('commission_amount');
    }

    // ============ UTILITY METHODS ============

    public function getWorkingHoursForDate($date): ?array
    {
        $shift = $this->scheduledShifts()
            ->where('shift_date', $date)
            ->first();

        if (!$shift) {
            return null;
        }

        return [
            'start' => $shift->start_time,
            'end' => $shift->end_time,
            'formatted' => Carbon::parse($shift->start_time)->format('g:i A') . ' - ' . Carbon::parse($shift->end_time)->format('g:i A')
        ];
    }

    public function isWorkingNow(): bool
    {
        $currentTime = Carbon::now()->format('H:i:s');
        $today = Carbon::today()->format('Y-m-d');

        return $this->scheduledShifts()
            ->where('shift_date', $today)
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>=', $currentTime)
            ->exists();
    }

    public function getNextAvailableSlot($duration, $date = null): ?array
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $maxDaysToCheck = 30; // Prevent infinite loop

        for ($i = 0; $i < $maxDaysToCheck; $i++) {
            $currentDate = $date->copy()->addDays($i);
            $slots = $this->getAvailableSlots($currentDate->format('Y-m-d'), $duration);

            if (!empty($slots)) {
                return [
                    'date' => $currentDate->format('Y-m-d'),
                    'slot' => $slots[0],
                    'all_slots' => $slots
                ];
            }
        }

        return null;
    }

    // ============ PERMISSION METHODS ============

    public function hasPermission($level): bool
    {
        $permissionLevels = [
            'no_access' => 0,
            'low' => 1,
            'medium' => 2,
            'high' => 3,
            'admin' => 4
        ];

        $userLevel = $permissionLevels[$this->permission_level] ?? 0;
        $requiredLevel = $permissionLevels[$level] ?? 0;

        return $userLevel >= $requiredLevel;
    }

    public function isAdmin(): bool
    {
        return $this->permission_level === 'admin';
    }

    public function canManageAppointments(): bool
    {
        return $this->hasPermission('medium');
    }

    public function canManageTeam(): bool
    {
        return $this->hasPermission('high');
    }

    // ============ STATISTICS METHODS ============

    public function getAppointmentStats($startDate = null, $endDate = null): array
    {
        $query = $this->appointments();

        if ($startDate) {
            $query->where('appointment_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('appointment_date', '<=', $endDate);
        }

        $totalAppointments = $query->count();
        $completedAppointments = $query->where('status', 'completed')->count();
        $cancelledAppointments = $query->where('status', 'cancelled')->count();
        $totalRevenue = $query->where('status', 'completed')->sum('price');
        $totalCommission = $query->where('status', 'completed')->sum('commission_amount');

        return [
            'total_appointments' => $totalAppointments,
            'completed_appointments' => $completedAppointments,
            'cancelled_appointments' => $cancelledAppointments,
            'completion_rate' => $totalAppointments > 0 ? ($completedAppointments / $totalAppointments) * 100 : 0,
            'total_revenue' => $totalRevenue,
            'total_commission' => $totalCommission,
            'net_revenue' => $totalRevenue - $totalCommission
        ];
    }

    public function getMonthlyStats($year = null): array
    {
        $year = $year ?: Carbon::now()->year;
        $stats = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            $monthStats = $this->getAppointmentStats($startDate, $endDate);
            $stats[$month] = $monthStats;
        }

        return $stats;
    }
}