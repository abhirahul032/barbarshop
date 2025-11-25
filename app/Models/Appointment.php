<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'team_member_id',
        'service_id',
        'client_name',
        'client_email',
        'client_phone',
        'client_notes',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'price',
        'commission_amount',
        'notes',
        'appointment_number',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(AppointmentService::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            $appointment->appointment_number = static::generateAppointmentNumber();
        });
    }

    public static function generateAppointmentNumber(): string
    {
        $prefix = 'APT';
        $date = now()->format('Ymd');
        
        do {
            $number = $prefix . $date . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('appointment_number', $number)->exists());

        return $number;
    }

    public function getFormattedStartTimeAttribute(): string
    {
        return $this->start_time->format('g:i A');
    }

    public function getFormattedEndTimeAttribute(): string
    {
        return $this->end_time->format('g:i A');
    }

    public function getDurationAttribute(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
}