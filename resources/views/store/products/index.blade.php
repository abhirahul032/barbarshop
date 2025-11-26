@extends('store.layouts.app')
@section('title','Products')
@section('content')
<div class="container-fluid">
    

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Products</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('store.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <a href="{{ route('store.products.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus mr-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Search and Filters Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('store.products.index') }}" class="row g-3 align-items-end">
                        {{-- Search Input --}}
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Products</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="search" 
                                       id="search"
                                       class="form-control" 
                                       placeholder="Search by name, SKU, barcode, brand..."
                                       value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div class="col-md-2">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Brand Filter --}}
                        <div class="col-md-2">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" 
                                        {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Stock Status Filter --}}
                        <div class="col-md-2">
                            <label for="stock_status" class="form-label">Stock Status</label>
                            <select name="stock_status" id="stock_status" class="form-select">
                                <option value="">All Stock</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                                    In Stock
                                </option>
                                <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>
                                    Low Stock
                                </option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>
                            </select>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa fa-filter mr-1"></i> Apply
                            </button>
                        </div>

                        {{-- Clear Filters --}}
                        @if(request()->hasAny(['search', 'category_id', 'brand_id', 'stock_status']))
                        <div class="col-12">
                            <a href="{{ route('store.products.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-times mr-1"></i> Clear Filters
                            </a>
                            <small class="text-muted ms-2">
                                {{ $products->total() }} results found
                            </small>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Results Summary --}}
                @if(request()->hasAny(['search', 'category_id', 'brand_id', 'stock_status']))
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle mr-2"></i>
                        Showing filtered results 
                        @if(request('search'))
                            for "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('category_id') && $selectedCategory = $categories->firstWhere('id', request('category_id')))
                            in category "<strong>{{ $selectedCategory->name }}</strong>"
                        @endif
                        @if(request('brand_id') && $selectedBrand = $brands->firstWhere('id', request('brand_id')))
                            from brand "<strong>{{ $selectedBrand->name }}</strong>"
                        @endif
                    </div>
                @endif

                <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Name</th>
                      <th>SKU</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Brand</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $p)
                    <tr>
                      <td style="width:80px;">
                        @if($p->images->first())
                          <img src="{{ asset('storage/'.$p->images->first()->path) }}" class="img-fluid rounded" alt="" style="width: 60px; height: 60px; object-fit: cover;" />
                        @else
                          <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-image text-muted"></i>
                          </div>
                        @endif
                      </td>
                      <td>
                        <div class="fw-semibold">{{ $p->name }}</div>
                        <small class="text-muted">{{ Str::limit($p->short_description, 50) }}</small>
                      </td>
                      <td>
                        <code>{{ $p->sku }}</code>
                        @if($p->barcode)
                          <br><small class="text-muted">{{ $p->barcode }}</small>
                        @endif
                      </td>
                      <td>${{ number_format($p->retail_price,2) }}</td>
                      <td>
                        @if($p->track_stock)
                          <span class="badge 
                            @if($p->stock_quantity == 0) bg-danger
                            @elseif($p->stock_quantity <= $p->low_stock_level) bg-warning
                            @else bg-success @endif">
                            {{ $p->stock_quantity }}
                          </span>
                        @else
                          <span class="badge bg-secondary">N/A</span>
                        @endif
                      </td>
                      <td>{{ $p->brand?->name ?? '-' }}</td>
                      <td>{{ $p->category?->name ?? '-' }}</td>
                      <td>
                        <span class="badge {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">
                          {{ $p->is_active ? 'Active' : 'Inactive' }}
                        </span>
                      </td>
                      <td class="text-end">
                        <div class="btn-group btn-group-sm">
                          <a href="{{ route('store.products.show', $p) }}" class="btn btn-outline-primary" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
                          <a href="{{ route('store.products.edit', $p) }}" class="btn btn-outline-secondary" title="Edit">
                            <i class="fa fa-edit"></i>
                          </a>
                          <form action="{{ route('store.products.destroy', $p) }}" method="POST" 
                                onsubmit="return confirm('Delete product?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                              <i class="fa fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                </div>

                {{-- Empty State --}}
                @if($products->isEmpty())
                  <div class="text-center py-5">
                    <i class="fa fa-search fa-3x text-muted mb-3"></i>
                    <h4>No products found</h4>
                    <p class="text-muted">
                      @if(request()->hasAny(['search', 'category_id', 'brand_id', 'stock_status']))
                        Try adjusting your search criteria or 
                        <a href="{{ route('store.products.index') }}">clear all filters</a>.
                      @else
                        No products available. 
                        <a href="{{ route('store.products.create') }}">Create your first product</a>.
                      @endif
                    </p>
                  </div>
                @endif
                
                {{ $products->links() }}
                    
                </div>
            </div>
        </div>
    </div>
    

</div>

{{-- Add some JavaScript for better UX --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when select filters change (optional)
    const autoSubmitFilters = document.querySelectorAll('#category_id, #brand_id, #stock_status');
    autoSubmitFilters.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Clear search input
    const searchInput = document.getElementById('search');
    if (searchInput && !searchInput.value) {
        searchInput.focus();
    }
});
</script>
@endpush

@endsection