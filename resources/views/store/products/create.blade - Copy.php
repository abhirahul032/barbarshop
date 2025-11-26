@extends('store.layouts.app')
@section('title','Add Product')
@section('content')
<h3>Add new product</h3>
@include('store.layouts.error')
<form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
  @csrf
  <input type="hidden" name="store_id" value="{{ old('store_id', $storeId ?? '') }}">

  <div class="row">
    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-header">Basic info</div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Product name <span class="text-danger">*</span></label>
            <input name="name" value="{{ old('name') }}" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Barcode (optional)</label>
            <input name="barcode" value="{{ old('barcode') }}" class="form-control" />
          </div>

          <div class="row">
            {{-- Brand Field with Add Button --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Brand</label>
              <div class="input-group">
                <select name="brand_id" id="brand_id" class="form-select">
                  <option value="">Select a brand</option>
                  @foreach($brands as $b)
                    <option value="{{ $b->id }}" @selected(old('brand_id')==$b->id)>{{ $b->name }}</option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
              <input type="hidden" name="new_brand_name" id="new_brand_name">
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

          {{-- Category Field with Add Button --}}
          <div class="mb-3">
            <label class="form-label">Category</label>
            <div class="input-group">
              <select name="category_id" id="category_id" class="form-select">
                <option value="">Select a category</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
                @endforeach
              </select>
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-plus"></i>
              </button>
            </div>
            <input type="hidden" name="new_category_name" id="new_category_name">
          </div>
        </div>
      </div>

      {{-- ... rest of your existing form sections (Pricing, Inventory) remain the same ... --}}
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
    <button type="submit" class="btn btn-success">Save product</button>
    <a href="{{ route('store.products.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>

{{-- Add Brand Modal --}}
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addBrandForm">
          @csrf
          <div class="mb-3">
            <label for="brandName" class="form-label">Brand Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="brandName" name="name" required>
            <div class="invalid-feedback" id="brandError"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveBrandBtn">Save Brand</button>
      </div>
    </div>
  </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addCategoryForm">
          @csrf
          <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="categoryName" name="name" required>
            <div class="invalid-feedback" id="categoryError"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Add Brand functionality
    $('#saveBrandBtn').click(function() {
        const brandName = $('#brandName').val().trim();
        const brandSelect = $('#brand_id');
        const brandError = $('#brandError');
        
        if (!brandName) {
            brandError.text('Brand name is required').show();
            $('#brandName').addClass('is-invalid');
            return;
        }

        $.ajax({
            url: '{{ route("store.products.brand.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: brandName
            },
            success: function(response) {
                if (response.success) {
                    // Add new brand to select
                    brandSelect.append(new Option(response.brand.name, response.brand.id, true, true));
                    
                    // Set the new brand as selected
                    brandSelect.val(response.brand.id).trigger('change');
                    
                    // Close modal and reset form
                    $('#addBrandModal').modal('hide');
                    $('#brandName').val('').removeClass('is-invalid');
                    brandError.hide();
                    
                    // Show success message
                    showToast('Brand added successfully!', 'success');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors && errors.name) {
                    brandError.text(errors.name[0]).show();
                    $('#brandName').addClass('is-invalid');
                }
            }
        });
    });

    // Add Category functionality
    $('#saveCategoryBtn').click(function() {
        const categoryName = $('#categoryName').val().trim();
        const categorySelect = $('#category_id');
        const categoryError = $('#categoryError');
        
        if (!categoryName) {
            categoryError.text('Category name is required').show();
            $('#categoryName').addClass('is-invalid');
            return;
        }

        $.ajax({
            url: '{{ route("store.products.category.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: categoryName
            },
            success: function(response) {
                if (response.success) {
                    // Add new category to select
                    categorySelect.append(new Option(response.category.name, response.category.id, true, true));
                    
                    // Set the new category as selected
                    categorySelect.val(response.category.id).trigger('change');
                    
                    // Close modal and reset form
                    $('#addCategoryModal').modal('hide');
                    $('#categoryName').val('').removeClass('is-invalid');
                    categoryError.hide();
                    
                    // Show success message
                    showToast('Category added successfully!', 'success');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors && errors.name) {
                    categoryError.text(errors.name[0]).show();
                    $('#categoryName').addClass('is-invalid');
                }
            }
        });
    });

    // Reset modal forms when closed
    $('#addBrandModal, #addCategoryModal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').hide();
    });

    // Remove validation on input
    $('#brandName, #categoryName').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').hide();
    });

    // Toast notification function
    function showToast(message, type = 'success') {
        // You can use your preferred toast library or create a simple one
        const toast = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.container-fluid').prepend(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 3000);
    }
});
</script>
@endpush

@endsection