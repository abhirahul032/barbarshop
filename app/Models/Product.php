<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id','supplier_id','brand_id','category_id',
        'name','barcode','sku','measure_unit','measure_amount',
        'short_description','description','supply_price','retail_price','markup_percent',
        'tax_rate_id','team_commission_enabled','team_commission_type','team_commission_value',
        'track_stock','stock_quantity','low_stock_level','reorder_quantity','low_stock_notifications','is_active'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class); // ensure Store exists
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
