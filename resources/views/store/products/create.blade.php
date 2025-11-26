@extends('store.layouts.app')
@section('title','Add Product')
@section('content')
<div class="page-title-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Add New Product</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('store.products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('store.products.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>
    </div>
</div>
@include('store.layouts.error')

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fa fa-plus-circle me-2"></i>Create New Product
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('store.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <input type="hidden" name="store_id" value="{{ old('store_id', $storeId ?? '') }}">

            <div class="row">
                <div class="col-md-8">
                    {{-- BASIC INFO --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0 text-primary">
                                <i class="fa fa-info-circle me-2"></i>Basic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                <input name="name" value="{{ old('name') }}" class="form-control form-control-lg" required 
                                       placeholder="Enter product name" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Barcode (Optional)</label>
                                <input name="barcode" value="{{ old('barcode') }}" class="form-control" 
                                       placeholder="Enter barcode" />
                            </div>

                            <div class="row">
                                {{-- Brand Field with Add Button --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Brand</label>
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
                                    <label class="form-label fw-semibold">Measure Unit</label>
                                    <input type="text" name="measure_unit" class="form-control" value="{{ old('measure_unit') }}" 
                                           placeholder="ml, kg, g, etc." />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-semibold">Amount</label>
                                    <input type="number" step="0.001" name="measure_amount" class="form-control" 
                                           value="{{ old('measure_amount') }}" placeholder="0.00" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Short Description</label>
                                <input name="short_description" value="{{ old('short_description') }}" class="form-control" 
                                       placeholder="Brief product description" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Description</label>
                                <textarea name="description" class="form-control" rows="5" 
                                          placeholder="Detailed product description">{{ old('description') }}</textarea>
                            </div>

                            {{-- Category Field with Add Button --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
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

                    {{-- PRICING --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0 text-success">
                                <i class="fa fa-tags me-2"></i>Pricing Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Supply Price (Cost)</label>
                                <div class="input-group">
                                    <span class="input-group-text">£</span>
                                    <input type="number" step="0.01" name="supply_price" class="form-control" 
                                           value="{{ old('supply_price',0) }}" placeholder="0.00" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Retail Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">£</span>
                                        <input type="number" step="0.01" name="retail_price" class="form-control" 
                                               value="{{ old('retail_price',0) }}" placeholder="0.00" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Markup Percentage</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="markup_percent" class="form-control" 
                                               value="{{ old('markup_percent',0) }}" placeholder="0.00" />
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="team_commission_enabled" 
                                       id="teamCommission" @checked(old('team_commission_enabled'))>
                                <label class="form-check-label fw-semibold" for="teamCommission">
                                    Enable Team Member Commission
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- INVENTORY --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0 text-warning">
                                <i class="fa fa-boxes me-2"></i>Inventory Management
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SKU (Stock Keeping Unit)</label>
                                <input name="sku" class="form-control" value="{{ old('sku') }}" 
                                       placeholder="Leave blank to auto-generate" />
                                <div class="form-text">If left empty, a unique SKU will be generated automatically.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Supplier</label>
                                <select name="supplier_id" class="form-select">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $s)
                                        <option value="{{ $s->id }}" @selected(old('supplier_id')==$s->id)>{{ $s->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="track_stock" 
                                       id="trackStock" @checked(old('track_stock'))>
                                <label class="form-check-label fw-semibold" for="trackStock">
                                    Track Stock Quantity
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Stock Quantity</label>
                                <input type="number" name="stock_quantity" value="{{ old('stock_quantity',0) }}" 
                                       class="form-control" placeholder="0" />
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Low Stock Level</label>
                                    <input type="number" name="low_stock_level" value="{{ old('low_stock_level',0) }}" 
                                           class="form-control" placeholder="0" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Reorder Quantity</label>
                                    <input type="number" name="reorder_quantity" value="{{ old('reorder_quantity',0) }}" 
                                           class="form-control" placeholder="0" />
                                </div>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="low_stock_notifications" 
                                       id="lowStockNotifications" @checked(old('low_stock_notifications'))>
                                <label class="form-check-label fw-semibold" for="lowStockNotifications">
                                    Receive Low Stock Notifications
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="col-md-4">
                    {{-- PRODUCT IMAGES --}}
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0 text-info">
                                <i class="fa fa-images me-2"></i>Product Images
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload Product Photos</label>
                                <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                                <div class="form-text">
                                    You can select multiple images. Supported formats: JPG, PNG, GIF.
                                </div>
                            </div>
                            
                            <div class="border rounded p-3 bg-light text-center">
                                <i class="fa fa-upload fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0 small">No images uploaded yet</p>
                            </div>
                        </div>
                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0 text-secondary">
                                <i class="fa fa-bolt me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fa fa-save me-2"></i>Save Product
                                </button>
                                <a href="{{ route('store.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fa fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Add Brand Modal --}}
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addBrandModalLabel">
                    <i class="fa fa-plus-circle me-2"></i>Add New Brand
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBrandForm">
                    @csrf
                    <div class="mb-3">
                        <label for="brandName" class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="brandName" name="name" required 
                               placeholder="Enter brand name">
                        <div class="invalid-feedback" id="brandError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveBrandBtn">
                    <i class="fa fa-save me-2"></i>Save Brand
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    <i class="fa fa-plus-circle me-2"></i>Add New Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="categoryName" class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="categoryName" name="name" required 
                               placeholder="Enter category name">
                        <div class="invalid-feedback" id="categoryError"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">
                    <i class="fa fa-save me-2"></i>Save Category
                </button>
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

    // Auto-calculate markup percentage when supply or retail price changes
    $('input[name="supply_price"], input[name="retail_price"]').on('change', function() {
        const supplyPrice = parseFloat($('input[name="supply_price"]').val()) || 0;
        const retailPrice = parseFloat($('input[name="retail_price"]').val()) || 0;
        
        if (supplyPrice > 0 && retailPrice > 0) {
            const markupPercent = ((retailPrice - supplyPrice) / supplyPrice) * 100;
            $('input[name="markup_percent"]').val(markupPercent.toFixed(2));
        }
    });

    // Auto-calculate retail price when markup changes
    $('input[name="markup_percent"]').on('change', function() {
        const supplyPrice = parseFloat($('input[name="supply_price"]').val()) || 0;
        const markupPercent = parseFloat($(this).val()) || 0;
        
        if (supplyPrice > 0) {
            const retailPrice = supplyPrice * (1 + markupPercent / 100);
            $('input[name="retail_price"]').val(retailPrice.toFixed(2));
        }
    });

    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.container-fluid').prepend(toast);
        
        setTimeout(() => {
            $('.alert').alert('close');
        }, 4000);
    }
});
</script>

<style>
.card {
    border: 1px solid #e3e6f0;
}

.card-header.bg-light {
    background-color: #f8f9fc !important;
    border-bottom: 1px solid #e3e6f0;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.input-group-text {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
}
</style>
@endpush

@endsection