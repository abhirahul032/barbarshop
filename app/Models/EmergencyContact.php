<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_member_id',
        'full_name',
        'relationship',
        'email',
        'phone_number'
    ];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }
}