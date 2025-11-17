@extends('admin.layouts.app')

@section('title', 'Business Types')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Business Types</h4>
    <a href="{{ route('admin.business-type.create') }}" class="btn btn-dark">Add Business Type</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.business-type.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or description..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        @if(request('search') || request('status') !== '')
                            <a href="{{ route('admin.business-type.index') }}" class="btn btn-outline-danger">Clear</a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
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
                    <a href="{{ route('admin.business-type.index', [
                        'search' => request('search'),
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
                <th>
                    <a href="{{ route('admin.business-type.index', [
                        'search' => request('search'),
                        'status' => request('status'),
                        'sort' => 'name', 
                        'direction' => ($sortField == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Name 
                        @if($sortField == 'name')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Description</th>
                <th>
                    <a href="{{ route('admin.business-type.index', [
                        'search' => request('search'),
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
            @foreach($businessTypes as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ Str::limit($type->description, 50) }}</td>
                    <td>
                        @if($type->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.business-type.show', $type->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.business-type.edit', $type->id) }}" class="btn btn-sm btn-outline-secondary">
                               <i class="ri-pencil-fill"></i>
                            </a>
                            <form action="{{ route('admin.business-type.destroy', $type->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button  class="btn btn-sm btn-outline-danger"   onclick="return confirm('Are you sure you want to delete this business type?')">
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
                Showing {{ $businessTypes->firstItem() ?? 0 }} to {{ $businessTypes->lastItem() ?? 0 }} of {{ $businessTypes->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($businessTypes->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $businessTypes->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($businessTypes->getUrlRange(1, $businessTypes->lastPage()) as $page => $url)
                        @if ($page == $businessTypes->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($businessTypes->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $businessTypes->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
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