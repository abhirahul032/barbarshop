<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlobalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_type_id',
        'name',
        'description',
        'type',
        'price',
        'hourly_price',
        'duration_minutes',
        'category',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'hourly_price' => 'decimal:2',
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
    ];

    /**
     * Get the business type that owns the global service.
     */
    public function businessType(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class);
    }

    /**
     * Scope active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by business type
     */
    public function scopeByBusinessType($query, $businessTypeId)
    {
        return $query->where('business_type_id', $businessTypeId);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

   /**
    * Get formatted price based on type
    */
   public function getFormattedPriceAttribute()
   {
       if ($this->type === 'hourly') {
           return '$' . number_format($this->hourly_price, 2) . '/hour';
       }

       return '$' . number_format($this->price, 2);
   }

   /**
    * Get formatted duration
    */
   public function getFormattedDurationAttribute()
   {
       $hours = floor($this->duration_minutes / 60);
       $minutes = $this->duration_minutes % 60;

       if ($hours > 0 && $minutes > 0) {
           return "{$hours}h {$minutes}m";
       } elseif ($hours > 0) {
           return "{$hours}h";
       } else {
           return "{$minutes}m";
       }
   }
   
  
   
}