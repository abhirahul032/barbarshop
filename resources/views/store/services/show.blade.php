@extends('store.layouts.app')

@section('title', 'Service Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Service Details</h4>
                    <div class="btn-group">
                        <a href="{{ route('store.services.edit', $service) }}" class="btn btn-primary">Edit Service</a>
                        <a href="{{ route('store.services.index') }}" class="btn btn-secondary">Back to Services</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Service Name:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <h5>{{ $service->name }}</h5>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Category:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <span class="badge bg-info text-capitalize">{{ $service->category }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Price:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <h4 class="text-primary">${{ number_format($service->price, 2) }}</h4>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Duration:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <span class="badge bg-secondary">
                                                {{ $service->duration_minutes }} minutes 
                                                ({{ $service->duration_minutes >= 60 ? floor($service->duration_minutes/60) . ' hour' . (floor($service->duration_minutes/60) > 1 ? 's' : '') . ($service->duration_minutes % 60 ? ' ' . $service->duration_minutes % 60 . ' minute' . (($service->duration_minutes % 60) > 1 ? 's' : '') : '') : '' }})
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <strong>Status:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($service->description)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <strong>Description:</strong>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="mb-0">{{ $service->description }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Statistics -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Service Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <div class="mb-3">
                                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                            <h3>{{ $service->employees()->count() }}</h3>
                                            <p class="text-muted">Assigned Employees</p>
                                        </div>
                                        
                                        @php
                                            $employeeCount = $service->employees()->count();
                                        @endphp
                                        
                                        @if($employeeCount > 0)
                                            <span class="badge bg-success">Fully staffed</span>
                                        @else
                                            <span class="badge bg-warning">No employees assigned</span>
                                        @endif
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">Created</small>
                                            <div class="fw-bold">{{ $service->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Last Updated</small>
                                            <div class="fw-bold">{{ $service->updated_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('store.services.edit', $service) }}" class="btn btn-primary">
                                            <i class="fas fa-edit me-2"></i>Edit Service
                                        </a>
                                        
                                        <form action="{{ route('store.services.destroy', $service) }}" method="POST" class="d-grid">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this service?')">
                                                <i class="fas fa-trash me-2"></i>Delete Service
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('store.services.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left me-2"></i>Back to Services
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Assigned Employees Section -->
                    @if($service->employees()->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Assigned Employees</h5>
                                    <span class="badge bg-primary">{{ $service->employees()->count() }} employees</span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Specialization</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($service->employees as $employee)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $employee->name }}</strong>
                                                    </td>
                                                    <td>{{ $employee->email }}</td>
                                                    <td>{{ $employee->phone ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $employee->specialization ?? 'General' }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $employee->is_active ? 'success' : 'danger' }}">
                                                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h4>No Employees Assigned</h4>
                                    <p class="text-muted">This service doesn't have any employees assigned yet.</p>
                                    <a href="#" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Assign Employees
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection