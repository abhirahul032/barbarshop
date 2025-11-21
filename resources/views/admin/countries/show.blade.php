@extends('admin.layouts.app')

@section('title', 'View Country')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Country Details</h4>
    <div>
        <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Back to List</a>
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
                <td>{{ $country->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $country->name }}</td>
            </tr>
            <tr>
                <th>ISO Code</th>
                <td>{{ $country->iso_code }}</td>
            </tr>
            <tr>
                <th>Phone Code</th>
                <td>{{ $country->phone_code }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $country->created_at->format('M d, Y H:i A') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $country->updated_at->format('M d, Y H:i A') }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection