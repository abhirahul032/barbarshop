@extends('store.layouts.app')

@section('title', 'Client Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-users text-primary me-2"></i>Client Management
            </h1>
            <p class="text-muted">Manage your clients and their information</p>
        </div>
        <a href="{{ route('store.clients.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Add New Client
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clients->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Memberships</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">--</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-id-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                New This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">--</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Avg. Appointments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">--</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-list me-2"></i>All Clients
            </h6>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search clients...">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa fa-filter me-2"></i>Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">All Clients</a></li>
                            <li><a class="dropdown-item" href="#">With Memberships</a></li>
                            <li><a class="dropdown-item" href="#">Active</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Clients Grid -->
            <div class="row">
                @forelse($clients as $client)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card client-card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-0">{{ $client->first_name }} {{ $client->last_name }}</h5>
                                        <small class="text-muted">ID: #{{ str_pad($client->id, 6, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-success">Active</span>
                            </div>
                            
                            <div class="client-info mb-3">
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fa fa-envelope me-1"></i> {{ $client->email }}
                                    </small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fa fa-phone me-1"></i> {{ $client->phone ?? 'N/A' }}
                                    </small>
                                </div>
                                @if($client->birthday)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fa fa-birthday-cake me-1"></i> 
                                        {{ $client->birthday->format('M d, Y') }}
                                    </small>
                                </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fa fa-calendar me-1"></i>
                                    {{ $client->created_at->format('M d, Y') }}
                                </small>
                                <div class="btn-group">
                                    <a href="{{ route('store.clients.show', $client) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       data-bs-toggle="tooltip" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('store.clients.edit', $client) }}" 
                                       class="btn btn-sm btn-outline-secondary"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('store.clients.destroy', $client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip" 
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this client?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fa fa-users fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Clients Found</h4>
                        <p class="text-muted">Get started by adding your first client.</p>
                        <a href="{{ route('store.clients.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Add New Client
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($clients->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $clients->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.client-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #e3f2fd;
}

.client-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    border-color: #2196f3;
}

.avatar {
    font-weight: 600;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.badge {
    font-size: 0.7rem;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-left: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endpush