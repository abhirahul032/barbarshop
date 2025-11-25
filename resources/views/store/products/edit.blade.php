@extends('store.layouts.app')
@section('title','Edit Product')
@section('content')
<h3>Edit Product</h3>
 @include('store.layouts.error')
<form action="{{ route('store.products.update', $product) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <input type="hidden" name="store_id" value="{{ $storeId }}">

  <div class="row">
    <div class="col-md-8">
      {{-- BASIC INFO --}}
      <div class="card mb-3">
        <div class="card-header">Basic info</div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Product name</label>
            <input name="name" value="{{ old('name', $product->name) }}" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Barcode (optional)</label>
            <input name="barcode" value="{{ old('barcode', $product->barcode) }}" class="form-control" />
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Brand</label>
              <select name="brand_id" class="form-select">
                <option value="">Select a brand</option>
                @foreach($brands as $b)
                  <option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id) == $b->id)>
                    {{ $b->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Measure</label>
              <input name="measure_unit" value="{{ old('measure_unit', $product->measure_unit) }}" class="form-control" />
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Amount</label>
              <input type="number" step="0.001" name="measure_amount" value="{{ old('measure_amount', $product->measure_amount) }}" class="form-control" />
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Short description</label>
            <input name="short_description" value="{{ old('short_description', $product->short_description) }}" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Product description</label>
            <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Product category</label>
            <select name="category_id" class="form-select">
              <option value="">Select a category</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>
                  {{ $c->name }}
                </option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      {{-- PRICING --}}
      <div class="card mb-3">
        <div class="card-header">Pricing</div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Supply price</label>
            <input type="number" name="supply_price" step="0.01" value="{{ old('supply_price', $product->supply_price) }}" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Retail price</label>
              <input type="number" name="retail_price" step="0.01" value="{{ old('retail_price', $product->retail_price) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Markup %</label>
              <input type="number" name="markup_percent" step="0.01" value="{{ old('markup_percent', $product->markup_percent) }}" class="form-control">
            </div>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="team_commission_enabled" @checked(old('team_commission_enabled', $product->team_commission_enabled))>
            <label class="form-check-label">Enable team member commission</label>
          </div>

        </div>
      </div>

      {{-- INVENTORY --}}
      <div class="card mb-3">
        <div class="card-header">Inventory</div>
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">SKU</label>
            <input name="sku" value="{{ old('sku', $product->sku) }}" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">Select a supplier</option>
              @foreach($suppliers as $s)
                <option value="{{ $s->id }}" @selected(old('supplier_id', $product->supplier_id) == $s->id)>
                  {{ $s->supplier_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="track_stock" @checked(old('track_stock', $product->track_stock))>
            <label class="form-check-label">Track stock quantity</label>
          </div>

          <div class="mb-3">
            <label>Current stock quantity</label>
            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Low stock level</label>
              <input type="number" name="low_stock_level" value="{{ old('low_stock_level', $product->low_stock_level) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label>Reorder quantity</label>
              <input type="number" name="reorder_quantity" value="{{ old('reorder_quantity', $product->reorder_quantity) }}" class="form-control">
            </div>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="low_stock_notifications" @checked(old('low_stock_notifications', $product->low_stock_notifications))>
            <label class="form-check-label">Receive low stock notifications</label>
          </div>

        </div>
      </div>

    </div>

    {{-- PRODUCT IMAGES --}}
    <div class="col-md-4">

      <div class="card mb-3">
        <div class="card-header">Product photos</div>
        <div class="card-body">

          <label class="form-label">Upload new images</label>
          <input type="file" name="images[]" multiple class="form-control mb-3">

          <h6>Existing images</h6>
          @foreach($product->images as $img)
            <div class="d-flex align-items-center mb-2">
              <img src="{{ asset('storage/'.$img->path) }}" class="me-2 rounded" width="70" height="70" />

              <form action="{{ route('store.products.update', $product) }}" method="POST" class="ms-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="delete_image_id" value="{{ $img->id }}">
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </div>
          @endforeach

        </div>
      </div>

    </div>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary">Update product</button>
    <a href="{{ route('store.products.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
@endsection
