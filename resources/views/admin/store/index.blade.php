@extends('admin.layouts.app')

@section('title', 'Stores')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Stores</h4>
    <a href="{{ route('admin.store.create') }}" class="btn btn-dark">Add Store</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.store.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email or URL..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        @if(request('search'))
                            <a href="{{ route('admin.store.index') }}" class="btn btn-outline-danger">Clear</a>
                        @endif
                    </div>
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
                    <a href="{{ route('admin.store.index', [
                        'search' => request('search'),
                        'sort' => 'name', 
                        'direction' => ($sortField == 'name' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Name 
                        @if($sortField == 'name')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Logo</th>
                <th>
                    <a href="{{ route('admin.store.index', [
                        'search' => request('search'),
                        'sort' => 'email', 
                        'direction' => ($sortField == 'email' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Email 
                        @if($sortField == 'email')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Package</th>
                <th>
                    <a href="{{ route('admin.store.index', [
                        'search' => request('search'),
                        'sort' => 'no_of_employees', 
                        'direction' => ($sortField == 'no_of_employees' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Employees 
                        @if($sortField == 'no_of_employees')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Billing Period</th>
                <th>Business Types</th>
                <th>Start Date</th>
                <th>End Date</th>

                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stores as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>
                        @if($s->logo)
                              <img src="{{ asset('storage/' . $s->logo) }}" width="50" height="50" style="object-fit: cover;" alt="{{ $s->name }} logo">
                        @else
                            <span class="text-muted">No logo</span>
                        @endif
                    </td>
                    <td>{{ $s->email }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $s->package->name }}</span>
                    </td>
                    <td>{{ $s->no_of_employees }}</td>

                    <td>
                        <span class="badge bg-{{ $s->billing_period == 'monthly' ? 'info' : 'warning' }}">
                            {{ ucfirst($s->billing_period) }}
                        </span>
                    </td>
                    <td>
                        @foreach($s->businessTypes as $businessType)
                            <span class="badge bg-secondary mb-1">{{ $businessType->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $s->start_date ? $s->start_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $s->end_date ? $s->end_date->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.store.show', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="ri-eye-fill"></i></a>
                            <a href="{{ route('admin.store.edit', $s->id) }}" class="btn btn-sm btn-outline-secondary"><i class="ri-pencil-fill"></i></a>
                            <form action="{{ route('admin.store.destroy', $s->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button  class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this package?')">
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
                Showing {{ $stores->firstItem() ?? 0 }} to {{ $stores->lastItem() ?? 0 }} of {{ $stores->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($stores->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $stores->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($stores->getUrlRange(1, $stores->lastPage()) as $page => $url)
                        @if ($page == $stores->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($stores->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $stores->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
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