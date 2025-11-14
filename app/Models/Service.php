<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class)
                    ->withPivot('expertise_level')
                    ->withTimestamps();
    }
}