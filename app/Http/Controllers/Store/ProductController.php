<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::guard('store')->user();
        $query = Product::where('store_id', $store->id);

        $products = $query->with(['brand','category','supplier','images'])
                          ->orderBy('created_at','desc')
                          ->paginate(15);

        return view('store.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $store = Auth::guard('store')->user();
        $brands = ProductBrand::where('store_id', $store->id)->get();
        $categories = ProductCategory::where('store_id', $store->id)->get();
        $suppliers = Supplier::where('store_id', $store->id)->get();
        $storeId=$store->id;

        return view('store.products.create', compact('brands','categories','suppliers','storeId'));
    }

    public function store(ProductRequest $request)
    {
        $store = Auth::guard('store')->user();
        
        return DB::transaction(function() use($request, $store) {
            $data = $request->validated();

            // Set store_id from authenticated store
            $data['store_id'] = $store->id;

            // Auto-generate SKU if not provided
            if (empty($data['sku'])) {
                $data['sku'] = $this->generateSku($data['name'] ?? 'PRD');
            }

            // Calculate markup percentage if supply & retail present
            if (isset($data['supply_price']) && isset($data['retail_price']) && $data['supply_price'] > 0) {
                $data['markup_percent'] = round((($data['retail_price'] - $data['supply_price']) / $data['supply_price']) * 100, 2);
            }

            // Normalize checkboxes
            $data['team_commission_enabled'] = $request->has('team_commission_enabled');
            $data['track_stock'] = $request->has('track_stock');

            $product = Product::create($data);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('product-images', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            return redirect()->route('store.products.index')
                             ->with('success','Product created successfully.');
        });
    }

    public function show(Product $product)
    {
        $this->authorizeAccess($product);
        $product->load(['brand','category','supplier','images']);
        return view('store.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorizeAccess($product);
        $store = Auth::guard('store')->user();
        $brands = ProductBrand::where('store_id', $store->id)->get();
        $categories = ProductCategory::where('store_id', $store->id)->get();
        $suppliers = Supplier::where('store_id', $store->id)->get();

        return view('store.products.edit', compact('product','brands','categories','suppliers'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorizeAccess($product);
        
        return DB::transaction(function() use($request, $product) {
            $data = $request->validated();

            if (isset($data['supply_price']) && isset($data['retail_price']) && $data['supply_price'] > 0) {
                $data['markup_percent'] = round((($data['retail_price'] - $data['supply_price']) / $data['supply_price']) * 100, 2);
            }

            $data['team_commission_enabled'] = $request->has('team_commission_enabled');
            $data['track_stock'] = $request->has('track_stock');

            $product->update($data);

            // Add any new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('product-images', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            // Handle image deletion if delete_image_id is present
            if ($request->has('delete_image_id')) {
                $image = ProductImage::find($request->delete_image_id);
                if ($image && $image->product_id === $product->id) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }

            return redirect()->route('store.products.index')
                             ->with('success','Product updated.');
        });
    }

    public function destroy(Product $product)
    {
        $this->authorizeAccess($product);
        
        // delete images from storage
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('store.products.index')
                         ->with('success','Product deleted.');
    }

    protected function generateSku($name = 'PRD')
    {
        $slug = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $name), 0, 6));
        $random = strtoupper(Str::random(4));
        $sku = $slug . '-' . $random;

        // ensure unique
        while (Product::where('sku', $sku)->exists()) {
            $random = strtoupper(Str::random(4));
            $sku = $slug . '-' . $random;
        }

        return $sku;
    }

    private function authorizeAccess(Product $product)
    {
        $store = Auth::guard('store')->user();
        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}