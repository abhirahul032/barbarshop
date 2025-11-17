@extends('admin.layouts.app')

@section('title', 'Global Services')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Global Services</h4>
    <a href="{{ route('admin.global-service.create') }}" class="btn btn-dark">Add Global Service</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.global-service.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search services..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="business_type_id" class="form-control" onchange="this.form.submit()">
                        <option value="">All Business Types</option>
                        @foreach($businessTypes as $type)
                            <option value="{{ $type->id }}" {{ request('business_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-control" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-control" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="hourly" {{ request('type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary w-100" type="submit">Filter</button>
                </div>
                @if(request()->anyFilled(['search', 'business_type_id', 'category', 'type', 'status']))
                    <div class="col-md-12 mt-2">
                        <a href="{{ route('admin.global-service.index') }}" class="btn btn-outline-danger btn-sm">Clear Filters</a>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>
                    <a href="{{ route('admin.global-service.index', [
                        'search' => request('search'),
                        'business_type_id' => request('business_type_id'),
                        'category' => request('category'),
                        'type' => request('type'),
                        'status' => request('status'),
                        'sort' => 'id', 
                        'direction' => ($sortField == 'id' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        ID 
                        @if($sortField == 'id')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Name</th>
                <th>Business Type</th>
                <th>Category</th>
                <th>Type</th>
                <th>Price</th>
                <th>Duration</th>
                <th>
                    <a href="{{ route('admin.global-service.index', [
                        'search' => request('search'),
                        'business_type_id' => request('business_type_id'),
                        'category' => request('category'),
                        'type' => request('type'),
                        'status' => request('status'),
                        'sort' => 'is_active', 
                        'direction' => ($sortField == 'is_active' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Status 
                        @if($sortField == 'is_active')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($globalServices as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>
                        <strong>{{ $service->name }}</strong>
                        @if($service->description)
                            <br><small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $service->businessType->name }}</td>
                    <td>{{ $service->category }}</td>
                    <td>
                        <span class="badge bg-{{ $service->type == 'fixed' ? 'primary' : 'info' }}">
                            {{ ucfirst($service->type) }}
                        </span>
                    </td>
                    <td>{{ $service->formatted_price }}</td>
                    <td>{{ $service->formatted_duration }}</td>
                    <td>
                        @if($service->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.global-service.show', $service->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.global-service.edit', $service->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ri-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.global-service.destroy', $service->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"  onclick="return confirm('Are you sure you want to delete this service?')">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $globalServices->firstItem() ?? 0 }} to {{ $globalServices->lastItem() ?? 0 }} of {{ $globalServices->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($globalServices->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $globalServices->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($globalServices->getUrlRange(1, $globalServices->lastPage()) as $page => $url)
                        @if ($page == $globalServices->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($globalServices->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $globalServices->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>

@endsection