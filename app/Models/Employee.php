<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'name', 'email', 'phone', 'address', 'date_of_birth',
        'hire_date', 'employment_type', 'working_days', 'start_time', 'end_time',
        'salary_per_hour', 'specialization', 'photo', 'emergency_contact_name',
        'emergency_contact_phone', 'bank_account_details', 'status'
    ];

    protected $casts = [
        'working_days' => 'array',
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'salary_per_hour' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)
                    ->withPivot('expertise_level')
                    ->withTimestamps();
    }

    public function getWeeklySalaryAttribute()
    {
        $workingDays = count($this->working_days ?? []);
        $hoursPerDay = $this->start_time->diffInHours($this->end_time);
        return $workingDays * $hoursPerDay * $this->salary_per_hour;
    }

    public function getMonthlySalaryAttribute()
    {
        return $this->weekly_salary * 4; // Approximation
    }
}