@extends('admin.layouts.app')

@section('title', 'View Package')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Package Details</h4>
    <div>
        <a href="{{ route('admin.package.edit', $package->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.package.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">ID</th>
                <td>{{ $package->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $package->name }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>${{ number_format($package->price, 2) }}</td>
            </tr>
            <tr>
                <th>Duration (Days)</th>
                <td>{{ $package->duration }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $package->created_at->format('M d, Y H:i A') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $package->updated_at->format('M d, Y H:i A') }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection