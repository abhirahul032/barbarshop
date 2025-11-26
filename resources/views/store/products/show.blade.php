@extends('store.layouts.app')
@section('title', $product->name)
@section('content')
<div class="page-title-box">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">{{ $product->name }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('store.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($product->name, 20) }}</li>
            </ol>
        </nav>
    </div>
    <div class="btn-group">
        <a href="{{ route('store.products.edit', $product) }}" class="btn btn-primary">
            <i class="fa fa-edit me-2"></i>Edit Product
        </a>
        <a href="{{ route('store.products.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back
        </a>
    </div>
</div></div>

<div class="row">
    {{-- LEFT SIDE - PRODUCT IMAGES --}}
    <div class="col-lg-5 col-xl-4">
        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    <i class="fa fa-images text-primary me-2"></i>Product Images
                </h5>
            </div>
            <div class="card-body text-center">
                @if($product->images->count())
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($product->images as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/'.$img->path) }}" 
                                         class="d-block w-100 rounded" 
                                         alt="{{ $product->name }}"
                                         style="max-height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if($product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            
                            <div class="carousel-indicators">
                                @foreach($product->images as $index => $img)
                                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}" 
                                            class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    {{-- Thumbnail Gallery --}}
                    @if($product->images->count() > 1)
                    <div class="row mt-3">
                        @foreach($product->images as $index => $img)
                            <div class="col-3">
                                <img src="{{ asset('storage/'.$img->path) }}" 
                                     class="img-thumbnail cursor-pointer {{ $index === 0 ? 'border-primary' : '' }}"
                                     style="height: 80px; object-fit: cover; width: 100%; cursor: pointer;"
                                     onclick="showImage({{ $index }})"
                                     alt="Thumbnail {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-image fa-4x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No images available</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Stats Card --}}
        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    <i class="fa fa-chart-bar text-info me-2"></i>Quick Stats
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ $product->stock_quantity ?? 0 }}</h4>
                            <small class="text-muted">In Stock</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success mb-1">${{ number_format($product->retail_price, 2) }}</h4>
                        <small class="text-muted">Retail Price</small>
                    </div>
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-info mb-1">{{ $product->markup_percent ?? 0 }}%</h4>
                            <small class="text-muted">Markup</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning mb-1">${{ number_format($product->supply_price, 2) }}</h4>
                        <small class="text-muted">Cost Price</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE - PRODUCT DETAILS --}}
    <div class="col-lg-7 col-xl-8">
        {{-- BASIC INFO CARD --}}
        <div class="card mb-4">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fa fa-info-circle text-primary me-2"></i>Basic Information
                </h5>
                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Product Name</label>
                        <p class="mb-0 fs-6">{{ $product->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">SKU</label>
                        <p class="mb-0">
                            <code class="bg-light px-2 py-1 rounded">{{ $product->sku }}</code>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Barcode</label>
                        <p class="mb-0">{{ $product->barcode ?: '<span class="text-muted">Not set</span>' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Brand</label>
                        <p class="mb-0">
                            @if($product->brand)
                                <span class="badge bg-light text-dark border">{{ $product->brand->name }}</span>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Category</label>
                        <p class="mb-0">
                            @if($product->category)
                                <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Measure</label>
                        <p class="mb-0">
                            @if($product->measure_amount && $product->measure_unit)
                                {{ $product->measure_amount }} {{ $product->measure_unit }}
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($product->short_description)
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted mb-1">Short Description</label>
                    <p class="mb-0 text-dark">{{ $product->short_description }}</p>
                </div>
                @endif

                @if($product->description)
                <div>
                    <label class="form-label fw-semibold text-muted mb-1">Description</label>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            {{-- PRICING CARD --}}
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-tags text-success me-2"></i>Pricing
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Supply Price</span>
                            <span class="fw-bold text-dark">${{ number_format($product->supply_price, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Retail Price</span>
                            <span class="fw-bold fs-5 text-success">${{ number_format($product->retail_price, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Markup</span>
                            <span class="fw-bold text-info">{{ $product->markup_percent }}%</span>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Team Commission</span>
                                <span class="badge bg-{{ $product->team_commission_enabled ? 'success' : 'secondary' }}">
                                    {{ $product->team_commission_enabled ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INVENTORY CARD --}}
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-boxes text-warning me-2"></i>Inventory
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Stock Tracking</span>
                                <span class="badge bg-{{ $product->track_stock ? 'info' : 'secondary' }}">
                                    {{ $product->track_stock ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>

                        @if($product->track_stock)
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted mb-1">Current Stock</label>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                    @php
                                        $maxStock = max($product->stock_quantity, $product->low_stock_level, 10);
                                        $stockPercent = ($product->stock_quantity / $maxStock) * 100;
                                        $progressClass = $product->stock_quantity == 0 ? 'bg-danger' : 
                                                        ($product->stock_quantity <= $product->low_stock_level ? 'bg-warning' : 'bg-success');
                                    @endphp
                                    <div class="progress-bar {{ $progressClass }}" 
                                         style="width: {{ $stockPercent }}%"></div>
                                </div>
                                <span class="fw-bold {{ $product->stock_quantity == 0 ? 'text-danger' : 
                                                    ($product->stock_quantity <= $product->low_stock_level ? 'text-warning' : 'text-success') }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label fw-semibold text-muted mb-1">Low Stock Level</label>
                                <p class="mb-0 fw-bold">{{ $product->low_stock_level ?? 0 }}</p>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold text-muted mb-1">Reorder Quantity</label>
                                <p class="mb-0 fw-bold">{{ $product->reorder_quantity ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Low Stock Alerts</span>
                                <span class="badge bg-{{ $product->low_stock_notifications ? 'success' : 'secondary' }}">
                                    {{ $product->low_stock_notifications ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fa fa-box-open fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Stock tracking is disabled</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SUPPLIER & ADDITIONAL INFO CARD --}}
        <div class="card">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    <i class="fa fa-truck text-info me-2"></i>Supplier & Additional Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Supplier</label>
                        <p class="mb-0">
                            @if($product->supplier)
                                <span class="badge bg-info text-white">{{ $product->supplier->supplier_name }}</span>
                            @else
                                <span class="text-muted">No supplier assigned</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted mb-1">Store</label>
                        <p class="mb-0">
                            <span class="badge bg-secondary">Store #{{ $product->store_id }}</span>
                        </p>
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted mb-1">Created</label>
                        <p class="mb-0">{{ $product->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted mb-1">Last Updated</label>
                        <p class="mb-0">{{ $product->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showImage(index) {
    const carousel = new bootstrap.Carousel(document.getElementById('productCarousel'));
    carousel.to(index);
}

// Add active class to thumbnail when carousel slides
document.getElementById('productCarousel').addEventListener('slid.bs.carousel', function (event) {
    const activeIndex = event.to;
    document.querySelectorAll('.img-thumbnail').forEach((thumb, index) => {
        thumb.classList.toggle('border-primary', index === activeIndex);
    });
});
</script>

<style>
.img-thumbnail {
    transition: all 0.3s ease;
    border-width: 2px;
}

.img-thumbnail:hover {
    transform: scale(1.05);
    border-color: #0d6efd !important;
}

.cursor-pointer {
    cursor: pointer;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header.bg-transparent {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.progress {
    background-color: #e9ecef;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@endsection