@extends('store.layouts.app')

@section('title', 'Services')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Services</h4>
                    <a href="{{ route('store.services.create') }}" class="btn btn-primary">Add Service</a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('store.services.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Search services..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category" class="form-control">
                                    <option value="">All Categories</option>
                                    <option value="hair" {{ request('category') == 'hair' ? 'selected' : '' }}>Hair</option>
                                    <option value="spa" {{ request('category') == 'spa' ? 'selected' : '' }}>Spa</option>
                                    <option value="coloring" {{ request('category') == 'coloring' ? 'selected' : '' }}>Coloring</option>
                                    <option value="beard" {{ request('category') == 'beard' ? 'selected' : '' }}>Beard</option>
                                    <option value="facial" {{ request('category') == 'facial' ? 'selected' : '' }}>Facial</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('store.services.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Services Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('store.services.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
                                            Service Name
                                            @if(request('sort') == 'name')
                                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Description</th>
                                    <th>
                                        <a href="{{ route('store.services.index', ['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
                                            Category
                                            @if(request('sort') == 'category')
                                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('store.services.index', ['sort' => 'price', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
                                            Price
                                            @if(request('sort') == 'price')
                                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Duration</th>
                                    <th>Employees</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                <tr>
                                    <td>
                                        <strong>{{ $service->name }}</strong>
                                    </td>
                                    <td>
                                        @if($service->description)
                                            <span title="{{ $service->description }}">
                                                {{ Str::limit($service->description, 50) }}
                                            </span>
                                        @else
                                            <span class="text-muted">No description</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-capitalize">{{ $service->category }}</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($service->price, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $service->duration_minutes }} minutes</span>
                                    </td>
                                    <td>
                                        @php
                                            $employeeCount = $service->employees()->count();
                                        @endphp
                                        @if($employeeCount > 0)
                                            <span class="badge bg-success">{{ $employeeCount }} employees</span>
                                        @else
                                            <span class="badge bg-warning">No employees</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}">
                                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('store.services.show', $service) }}" class=""><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                            <a href="{{ route('store.services.edit', $service) }}" class=""><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                            <form action="{{ route('store.services.destroy', $service) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border:0px;" class=""  onclick="return confirm('Are you sure you want to delete this service?')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of {{ $services->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($services->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $services->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                        @if ($page == $services->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($services->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $services->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            </nav>
        </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection