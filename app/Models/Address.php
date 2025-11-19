<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'address_name',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'is_primary'
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ];
        
        return implode(', ', array_filter($parts));
    }
}