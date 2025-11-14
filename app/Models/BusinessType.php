<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Many-to-many relationship with Store
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'business_type_store');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}