<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use Notifiable;

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Many-to-many relationship with BusinessType
    public function businessTypes()
    {
        return $this->belongsToMany(BusinessType::class, 'business_type_store');
    }

    // One-to-many relationship with Service
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Helper method to get business type names
    public function getBusinessTypeNamesAttribute()
    {
        return $this->businessTypes->pluck('name')->implode(', ');
    }
    public function employees()
{
    return $this->hasMany(Employee::class);
}
}