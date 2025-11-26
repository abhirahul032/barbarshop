<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        // adapt authorization as needed
        return true;
    }

    public function rules()
    {
        $id = $this->route('product') ? $this->route('product')->id : null;

        return [
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'brand_id' => 'nullable|exists:product_brands,id',
            'category_id' => 'nullable|exists:product_categories,id',
            'new_brand_name' => 'nullable|string|max:255',
            'new_category_name' => 'nullable|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'measure_unit' => 'nullable|string|max:50',
            'measure_amount' => 'nullable|numeric',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'supply_price' => 'nullable|numeric|min:0',
            'retail_price' => 'nullable|numeric|min:0',
            'markup_percent' => 'nullable|numeric',
            'team_commission_enabled' => 'sometimes|boolean',
            'team_commission_type' => 'nullable|in:fixed,percentage',
            'team_commission_value' => 'nullable|numeric|min:0',
            'track_stock' => 'sometimes|boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'low_stock_level' => 'nullable|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|max:5120'
        ];
    }
}
