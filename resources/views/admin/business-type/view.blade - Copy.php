@extends('admin.layouts.app')

@section('title', 'Business Type Details')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Business Type Details</h4>
    <div>
        <a href="{{ route('admin.business-type.edit', $businessType->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.business-type.index') }}" class="btn btn-secondary">Back to List</a>
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
                        <td>{{ $businessType->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $businessType->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $businessType->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($businessType->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $businessType->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $businessType->updated_at->format('M d, Y H:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection