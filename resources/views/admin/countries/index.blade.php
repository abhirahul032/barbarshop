@extends('admin.layouts.app')

@section('title', 'Countries')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Countries</h4>
    <a href="{{ route('admin.countries.create') }}" class="btn btn-dark">Add Country</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.countries.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or ISO code..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        @if(request('search'))
                            <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-danger">Clear</a>
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
                    <a href="{{ route('admin.countries.index', [
                        'search' => request('search'),
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
                    <a href="{{ route('admin.countries.index', [
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
                <th>
                    <a href="{{ route('admin.countries.index', [
                        'search' => request('search'),
                        'sort' => 'iso_code', 
                        'direction' => ($sortField == 'iso_code' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        ISO Code 
                        @if($sortField == 'iso_code')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.countries.index', [
                        'search' => request('search'),
                        'sort' => 'phone_code', 
                        'direction' => ($sortField == 'phone_code' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Phone Code 
                        @if($sortField == 'phone_code')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->iso_code }}</td>
                    <td>{{ $country->phone_code }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.countries.show', $country->id) }}" class="btn btn-sm btn-outline-primary"> 
                                <i class="ri-eye-fill"></i> 
                            </a>
                            <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ri-pencil-fill"></i> 
                            </a>
                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this country?')">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $countries->firstItem() ?? 0 }} to {{ $countries->lastItem() ?? 0 }} of {{ $countries->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($countries->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $countries->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($countries->getUrlRange(1, $countries->lastPage()) as $page => $url)
                        @if ($page == $countries->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($countries->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $countries->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
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