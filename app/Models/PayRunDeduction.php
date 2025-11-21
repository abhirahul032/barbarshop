<?php
// app/Models/PayRunDeduction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRunDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay_run_history_id',
        'description',
        'amount',
        'type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function payRunHistory()
    {
        return $this->belongsTo(PayRunHistory::class);
    }
}