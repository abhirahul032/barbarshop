<?php
// app/Models/ClientMembership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientMembership extends Model
{
    protected $fillable = [
        'client_id',
        'membership_id',
        'sessions_used',
        'sessions_remaining',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'sessions_used' => 'integer',
        'sessions_remaining' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(MembershipRedemption::class);
    }
     // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>=', now()->toDateString())
            ->where(function($q) {
                $q->where('sessions_remaining', '>', 0)
                  ->orWhereHas('membership', function($q) {
                      $q->where('session_type', 'unlimited');
                  });
            });
    }

    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'expired')
              ->orWhere('end_date', '<', now()->toDateString())
              ->orWhere(function($q) {
                  $q->where('status', 'active')
                    ->where('sessions_remaining', '<=', 0)
                    ->whereHas('membership', function($q) {
                        $q->where('session_type', 'limited');
                    });
              });
        });
    }

    // Helper methods
    public function canRedeemSession(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if (now()->gt($this->end_date)) {
            return false;
        }

        if ($this->membership->session_type === 'unlimited') {
            return true;
        }

        return $this->sessions_remaining > 0;
    }

    public function redeemSession(): bool
    {
        if (!$this->canRedeemSession()) {
            return false;
        }

        if ($this->membership->session_type === 'limited') {
            $this->sessions_used += 1;
            $this->sessions_remaining -= 1;
        }

        // Check if membership should be expired after redemption
        if ($this->membership->session_type === 'limited' && $this->sessions_remaining <= 0) {
            $this->status = 'expired';
        }

        return $this->save();
    }
}