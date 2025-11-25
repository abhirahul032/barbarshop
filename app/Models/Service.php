<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'name', 'description', 'price', 'duration_minutes', 
        'category', 'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

     // Add this relationship to existing Service model
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }    
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class)
                    ->withPivot('expertise_level')
                    ->withTimestamps();
    }
}