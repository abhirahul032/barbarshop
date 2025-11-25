<?php
// app/Models/Supplier.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'supplier_name',
        'supplier_description',
        'first_name',
        'last_name',
        'mobile_number',
        'telephone',
        'email',
        'website',
        'street',
        'suburb',
        'city',
        'state',
        'postal_code',
        'country',
        'same_as_postal',
        'supplier_code'
    ];

    protected $casts = [
        'same_as_postal' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
     public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Generate supplier code automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            if (empty($supplier->supplier_code)) {
                $supplier->supplier_code = 'SUP' . str_pad(static::where('store_id', $supplier->store_id)->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->street,
            $this->suburb,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }
}