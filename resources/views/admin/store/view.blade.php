@extends('admin.layouts.app')

@section('title', 'Store Details')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Store Details</h4>
    <div>
        <a href="{{ route('admin.store.edit', $store->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">Back to List</a>
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
                        <td>{{ $store->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $store->name }}</td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td>
                            <a href="{{ $store->url }}" target="_blank" class="text-decoration-none">
                                {{ $store->url }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $store->email }}</td>
                    </tr>
                    <tr>
                        <th>Number of Employees</th>
                        <td>{{ $store->no_of_employees }}</td>
                    </tr>
                    <tr>
                        <th>Package</th>
                        <td>
                            <span class="badge bg-primary">{{ $store->package->name }}</span>
                        </td>
                    </tr>


                    <tr>
                        <th>Billing Period</th>
                        <td>
                            <span class="badge bg-{{ $store->billing_period == 'monthly' ? 'info' : 'warning' }}">
                                {{ ucfirst($store->billing_period) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $store->start_date ? $store->start_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ $store->end_date ? $store->end_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Business Types</th>
                        <td>
                            @foreach($store->businessTypes as $businessType)
                                <span class="badge bg-primary mb-1">{{ $businessType->name }}</span>
                            @endforeach
                        </td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $store->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $store->updated_at->format('M d, Y H:i A') }}</td>
                    </tr>



                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Store Logo</h5>
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" 
                         class="img-fluid rounded" 
                         style="max-height: 200px; object-fit: cover;"
                         alt="{{ $store->name }} logo">
                @else
                    <div class="text-muted py-4">
                        <i class="fas fa-store fa-3x mb-2"></i>
                        <p>No logo uploaded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection