<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function scheduledShifts()
    {
        return $this->hasMany(ScheduledShift::class);
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
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
     // Add this relationship
    public function wage()
    {
        return $this->hasOne(Wage::class);
    }
    public function store()
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

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRatingDisplayAttribute()
    {
        return $this->review_count > 0 ? number_format($this->rating, 1) . ' (' . $this->review_count . ' reviews)' : 'No reviews yet';
    }
}