@extends('store.layouts.app')
@section('title','Add Product')
@section('content')
<h3>Add new product</h3>
 @include('store.layouts.error')
<form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="store_id" value="{{ old('store_id', $storeId ?? '') }}">

  <div class="row">
    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-header">Basic info</div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Product name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Barcode (optional)</label>
            <input name="barcode" value="{{ old('barcode') }}" class="form-control" />
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Brand</label>
              <select name="brand_id" class="form-select">
                <option value="">Select a brand</option>
                @foreach($brands as $b)
                  <option value="{{ $b->id }}" @selected(old('brand_id')==$b->id)>{{ $b->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Measure</label>
              <input type="text" name="measure_unit" class="form-control" value="{{ old('measure_unit') }}" placeholder="ml" />
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Amount</label>
              <input type="number" step="0.001" name="measure_amount" class="form-control" value="{{ old('measure_amount') }}" />
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Short description</label>
            <input name="short_description" value="{{ old('short_description') }}" class="form-control" />
          </div>

          <div class="mb-3">
            <label class="form-label">Product description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
              <option value="">Select a category</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">Pricing</div>
        <div class="card-body">
          <div class="mb-3">
            <label>Supply price</label>
            <input type="number" step="0.01" name="supply_price" class="form-control" value="{{ old('supply_price',0) }}" />
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Retail price</label>
              <input type="number" step="0.01" name="retail_price" class="form-control" value="{{ old('retail_price',0) }}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Markup %</label>
              <input type="number" step="0.01" name="markup_percent" class="form-control" value="{{ old('markup_percent',0) }}" />
            </div>
          </div>

          <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" name="team_commission_enabled" id="teamCommission" @checked(old('team_commission_enabled'))>
            <label class="form-check-label" for="teamCommission">Enable team member commission</label>
          </div>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">Inventory</div>
        <div class="card-body">
          <div class="mb-3">
            <label>SKU</label>
            <input name="sku" class="form-control" value="{{ old('sku') }}" placeholder="Leave blank to auto generate"/>
          </div>

          <div class="mb-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-select">
              <option value="">Select a supplier</option>
              @foreach($suppliers as $s)
                <option value="{{ $s->id }}" @selected(old('supplier_id')==$s->id)>{{ $s->supplier_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="track_stock" id="trackStock" @checked(old('track_stock'))>
            <label class="form-check-label" for="trackStock">Track stock quantity</label>
          </div>

          <div class="mb-3">
            <label>Current stock quantity</label>
            <input type="number" name="stock_quantity" value="{{ old('stock_quantity',0) }}" class="form-control" />
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Low stock level</label>
              <input type="number" name="low_stock_level" value="{{ old('low_stock_level',0) }}" class="form-control" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Reorder quantity</label>
              <input type="number" name="reorder_quantity" value="{{ old('reorder_quantity',0) }}" class="form-control" />
            </div>
          </div>

          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="low_stock_notifications" id="lowStockNotifications" @checked(old('low_stock_notifications'))>
            <label class="form-check-label" for="lowStockNotifications">Receive low stock notifications</label>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-header">Product photos</div>
        <div class="card-body">
          <label class="form-label">Upload photos</label>
          <input type="file" name="images[]" multiple class="form-control" accept="image/*">
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-success">Save product</button>
    <a href="{{ route('store.products.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
@endsection
