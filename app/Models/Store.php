<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'url',
        'email',
        'password',
        'no_of_employees',
        'package_id',
        'billing_period',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Many-to-many relationship with BusinessType
    public function businessTypes()
    {
        return $this->belongsToMany(BusinessType::class, 'business_type_store');
    }

    // Helper method to get business type names
    public function getBusinessTypeNamesAttribute()
    {
        return $this->businessTypes->pluck('name')->implode(', ');
    }
}
