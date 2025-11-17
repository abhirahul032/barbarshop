@extends('admin.layouts.app')

@section('title', 'Global Service Details')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Global Service Details</h4>
    <div>
        <a href="{{ route('admin.global-service.edit', $globalService->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.global-service.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $globalService->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $globalService->name }}</td>
                    </tr>
                    <tr>
                        <th>Business Type</th>
                        <td>{{ $globalService->businessType->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $globalService->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $globalService->category }}</td>
                    </tr>
                    <tr>
                        <th>Service Type</th>
                        <td>
                            <span class="badge bg-{{ $globalService->type == 'fixed' ? 'primary' : 'info' }}">
                                {{ ucfirst($globalService->type) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $globalService->formatted_price }}</td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $globalService->formatted_duration }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($globalService->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $globalService->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $globalService->updated_at->format('M d, Y H:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection