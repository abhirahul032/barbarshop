{{-- resources/views/store/memberships/show.blade.php --}}
@extends('store.layouts.app')

@section('title', $membership->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('store.memberships.index') }}" class="btn btn-secondary">
                        <i class="fa faarrow-left me-1"></i> Back
                    </a>
                </div>
                <h4 class="page-title">{{ $membership->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Membership Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="card-title">{{ $membership->name }}</h4>
                            <p class="text-muted">{{ $membership->description }}</p>
                        </div>
                        <span class="badge bg-{{ $membership->is_active ? 'success' : 'secondary' }} fs-6">
                            {{ $membership->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Price:</strong>
                                <span class="fs-5 text-primary">${{ number_format($membership->price, 2) }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Validity:</strong>
                                <span>{{ $membership->validity_duration }} {{ str($membership->validity_period)->plural() }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Sessions:</strong>
                                <span>
                                    @if($membership->session_type === 'unlimited')
                                        Unlimited
                                    @else
                                        {{ $membership->session_count }} sessions
                                    @endif
                                </span>
                            </div>
                            <div class="mb-3">
                                <strong>Tax Rate:</strong>
                                <span>
                                    {{ $membership->taxRate ? $membership->taxRate->name . ' (' . $membership->taxRate->rate . '%)' : 'No tax' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Included Services -->
                    <div class="mb-4">
                        <h5>Included Services</h5>
                        <div class="list-group">
                            @foreach($membership->services as $service)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $service->name }}</h6>
                                            <small class="text-muted">{{ $service->category }}</small>
                                        </div>
                                        <span class="text-primary">${{ number_format($service->price, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Online Settings -->
                    <div class="mb-4">
                        <h5>Online Settings</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled 
                                           {{ $membership->online_sales_enabled ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Online Sales Enabled
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled 
                                           {{ $membership->online_redemption_enabled ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Online Redemption Enabled
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    @if($membership->terms_conditions)
                    <div>
                        <h5>Terms & Conditions</h5>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($membership->terms_conditions)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Color & Stats -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Color</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="color-preview me-3" 
                             style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $membership->color }}"></div>
                        <span>{{ $membership->color }}</span>
                    </div>

                    <div class="mt-4">
                        <h5 class="card-title">Statistics</h5>
                        <div class="mb-2">
                            <small class="text-muted">Active Clients:</small>
                            <strong class="float-end">{{ $membership->clientMemberships->where('status', 'active')->count() }}</strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Total Clients:</small>
                            <strong class="float-end">{{ $membership->clientMemberships->count() }}</strong>
                        </div>
                        <div>
                            <small class="text-muted">Created:</small>
                            <strong class="float-end">{{ $membership->created_at->format('M j, Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('store.memberships.edit', $membership) }}" class="btn btn-primary">
                            <i class="fa faedit me-1"></i> Edit Membership
                        </a>
                        <form action="{{ route('store.memberships.toggle-status', $membership) }}" method="POST" class="d-grid">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-{{ $membership->is_active ? 'warning' : 'success' }}">
                                <i class="fa fa{{ $membership->is_active ? 'pause' : 'play' }} me-1"></i>
                                {{ $membership->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('store.memberships.destroy', $membership) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure? This action cannot be undone.')">
                                <i class="fa fatrash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.color-preview {
    border: 2px solid #dee2e6;
}
</style>