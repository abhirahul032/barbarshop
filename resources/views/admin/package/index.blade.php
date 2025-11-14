@extends('admin.layouts.app')

@section('title', 'Packages')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Packages</h4>
    <a href="{{ route('admin.package.create') }}" class="btn btn-dark">Add Package</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.package.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        @if(request('search'))
                            <a href="{{ route('admin.package.index') }}" class="btn btn-outline-danger">Clear</a>
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
                    <a href="{{ route('admin.package.index', [
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
                    <a href="{{ route('admin.package.index', [
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
                    <a href="{{ route('admin.package.index', [
                        'search' => request('search'),
                        'sort' => 'price', 
                        'direction' => ($sortField == 'price' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Price 
                        @if($sortField == 'price')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{ route('admin.package.index', [
                        'search' => request('search'),
                        'sort' => 'duration', 
                        'direction' => ($sortField == 'duration' && $sortDirection == 'asc') ? 'desc' : 'asc'
                    ]) }}">
                        Duration (Days) 
                        @if($sortField == 'duration')
                            {!! $sortDirection == 'asc' ? '&#9650;' : '&#9660;' !!}
                        @endif
                    </a>
                </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($packages as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>${{ number_format($p->price, 2) }}</td>
                    <td>{{ $p->duration }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.package.show', $p->id) }}" class=""> <i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                            <a href="{{ route('admin.package.edit', $p->id) }}" class=""><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> </a>
                            <form action="{{ route('admin.package.destroy', $p->id) }}" method="POST" class="">
                                @csrf @method('DELETE')
                                <button style="border:0px;" class="" onclick="return confirm('Are you sure you want to delete this package?')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $packages->firstItem() ?? 0 }} to {{ $packages->lastItem() ?? 0 }} of {{ $packages->total() }} results
            </div>
            
            <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($packages->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $packages->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($packages->getUrlRange(1, $packages->lastPage()) as $page => $url)
                        @if ($page == $packages->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($packages->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $packages->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}" rel="next">Next</a>
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