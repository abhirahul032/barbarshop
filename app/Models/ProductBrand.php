<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $fillable = ['store_id','name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
