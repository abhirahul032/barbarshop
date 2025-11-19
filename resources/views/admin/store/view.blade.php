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

<!-- Tabs Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="storeTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="true">
                            <i class="fas fa-concierge-bell me-2"></i>Services
                            <span class="badge bg-primary ms-2">{{ $store->services->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees" aria-selected="false">
                            <i class="fas fa-users me-2"></i>Employees
                            <span class="badge bg-primary ms-2">{{ $store->employees->count() }}</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="storeTabsContent">
                    <!-- Services Tab -->
                    <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="services-tab">
                        @if($store->services->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Price</th>
                                            <th>Hourly Price</th>
                                            <th>Duration</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($store->services as $service)
                                            <tr>
                                                <td>{{ $service->name }}</td>
                                                <td>{{ $service->description ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $service->type == 'hourly' ? 'warning' : 'info' }}">
                                                        {{ ucfirst($service->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($service->type !== 'hourly')
                                                        ${{ number_format($service->price, 2) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($service->type === 'hourly')
                                                        ${{ number_format($service->hourly_price, 2) }}/hour
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($service->duration_minutes)
                                                        @php
                                                            $hours = floor($service->duration_minutes / 60);
                                                            $minutes = $service->duration_minutes % 60;
                                                            $duration = '';
                                                            if ($hours > 0) $duration .= "{$hours}h ";
                                                            if ($minutes > 0) $duration .= "{$minutes}m";
                                                        @endphp
                                                        {{ $duration ?: 'N/A' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $service->category ?? 'General' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}">
                                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Services Summary -->
                            <div class="mt-3 p-3 bg-light rounded">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Total Services:</strong> {{ $store->services->count() }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Active Services:</strong> {{ $store->services->where('is_active', true)->count() }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Categories:</strong> {{ $store->services->pluck('category')->unique()->count() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Services Found</h5>
                                <p class="text-muted">This store doesn't have any services yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Employees Tab -->
                    <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                        @if($store->employees->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Specialization</th>
                                            <th>Employment Type</th>
                                            <th>Status</th>
                                            <th>Salary/Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($store->employees as $employee)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($employee->photo)
                                                            <img src="{{ asset('storage/' . $employee->photo) }}" 
                                                                 class="rounded-circle me-2" 
                                                                 width="32" height="32" 
                                                                 alt="{{ $employee->name }}"
                                                                 style="object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" 
                                                                 style="width: 32px; height: 32px;">
                                                                <i class="fas fa-user text-white"></i>
                                                            </div>
                                                        @endif
                                                        {{ $employee->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $employee->email }}</td>
                                                <td>{{ $employee->phone ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $employee->specialization ?? 'General' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $employee->employment_type == 'full_time' ? 'primary' : 'warning' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $employee->employment_type)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $employee->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($employee->status) }}
                                                    </span>
                                                </td>
                                                <td>${{ number_format($employee->salary_per_hour, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Employees Summary -->
                            <div class="mt-3 p-3 bg-light rounded">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Total Employees:</strong> {{ $store->employees->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Active Employees:</strong> {{ $store->employees->where('status', 'active')->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Full Time:</strong> {{ $store->employees->where('employment_type', 'full_time')->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Part Time:</strong> {{ $store->employees->where('employment_type', 'part_time')->count() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Employees Found</h5>
                                <p class="text-muted">This store doesn't have any employees yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1rem;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 2px solid #0d6efd;
    }
    
    .nav-tabs .nav-link:hover {
        color: #0d6efd;
        border-bottom: 2px solid #dee2e6;
    }
</style>
@endpush