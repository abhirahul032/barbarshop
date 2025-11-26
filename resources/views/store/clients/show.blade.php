@extends('store.layouts.app')

@section('title', $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-user-circle text-primary me-2"></i>
                {{ $client->first_name }} {{ $client->last_name }}
            </h1>
            <p class="text-muted">Client Profile & Information</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('store.clients.edit', $client) }}" class="btn btn-primary">
                <i class="fa fa-edit me-2"></i>Edit Client
            </a>
            <a href="{{ route('store.clients.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back to Clients
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs card-header-tabs" id="clientTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="fa fa-user me-2"></i>Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="memberships-tab" data-bs-toggle="tab" data-bs-target="#memberships" type="button" role="tab">
                                <i class="fa fa-id-card me-2"></i>Memberships
                                @if($client->activeMemberships->count() > 0)
                                <span class="badge bg-success ms-1">{{ $client->activeMemberships->count() }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab">
                                <i class="fa fa-map-marker-alt me-2"></i>Addresses
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="clientTabsContent">
                        
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <!-- Client Profile Sidebar -->
                                <div class="col-lg-4">
                                    <!-- Profile Card -->
                                    <div class="card shadow mb-4">
                                        <div class="card-body text-center">
                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                                {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                                            </div>
                                            <h4 class="card-title">{{ $client->first_name }} {{ $client->last_name }}</h4>
                                            <p class="text-muted">Client ID: #{{ str_pad($client->id, 6, '0', STR_PAD_LEFT) }}</p>
                                            
                                            <div class="d-flex justify-content-center gap-2 mb-3">
                                                <span class="badge bg-success">Active Client</span>
                                                @if($client->activeMemberships->count() > 0)
                                                <span class="badge bg-info">Active Memberships: {{ $client->activeMemberships->count() }}</span>
                                                @endif
                                            </div>

                                            <!-- Quick Actions -->
                                            <div class="d-grid gap-2">
                                                <a href="#memberships" class="btn btn-outline-primary" onclick="switchToTab('memberships-tab')">
                                                    <i class="fa fa-id-card me-2"></i>Manage Memberships
                                                </a>
                                                <button class="btn btn-outline-success">
                                                    <i class="fa fa-shopping-cart me-2"></i>New Sale
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header bg-primary text-white py-3">
                                            <h6 class="mb-0">
                                                <i class="fa fa-address-card me-2"></i>Contact Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong><i class="fa fa-envelope text-primary me-2"></i>Email</strong>
                                                <p class="mb-1">{{ $client->email }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <strong><i class="fa fa-phone text-primary me-2"></i>Phone</strong>
                                                <p class="mb-1">{{ $client->phone ?? 'Not provided' }}</p>
                                            </div>
                                            @if($client->additional_email)
                                            <div class="mb-3">
                                                <strong><i class="fa fa-envelope text-primary me-2"></i>Additional Email</strong>
                                                <p class="mb-1">{{ $client->additional_email }}</p>
                                            </div>
                                            @endif
                                            @if($client->additional_phone)
                                            <div class="mb-3">
                                                <strong><i class="fa fa-mobile-alt text-primary me-2"></i>Additional Phone</strong>
                                                <p class="mb-1">{{ $client->additional_phone }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Notification Settings -->
                                    <div class="card shadow">
                                        <div class="card-header bg-warning text-dark py-3">
                                            <h6 class="mb-0">
                                                <i class="fa fa-bell me-2"></i>Notification Settings
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <i class="fa fa-envelope {{ $client->email_notifications ? 'text-success' : 'text-muted' }} me-2"></i>
                                                Email Notifications
                                                <span class="badge bg-{{ $client->email_notifications ? 'success' : 'secondary' }} float-end">
                                                    {{ $client->email_notifications ? 'ON' : 'OFF' }}
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <i class="fa fa-sms {{ $client->text_message_notifications ? 'text-success' : 'text-muted' }} me-2"></i>
                                                SMS Notifications
                                                <span class="badge bg-{{ $client->text_message_notifications ? 'success' : 'secondary' }} float-end">
                                                    {{ $client->text_message_notifications ? 'ON' : 'OFF' }}
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <i class="fa fa-whatsapp {{ $client->whatsapp_notifications ? 'text-success' : 'text-muted' }} me-2"></i>
                                                WhatsApp Notifications
                                                <span class="badge bg-{{ $client->whatsapp_notifications ? 'success' : 'secondary' }} float-end">
                                                    {{ $client->whatsapp_notifications ? 'ON' : 'OFF' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content -->
                                <div class="col-lg-8">
                                    <!-- Personal Information -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header bg-info text-white py-3">
                                            <h6 class="mb-0">
                                                <i class="fa fa-user me-2"></i>Personal Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>First Name</strong>
                                                        <p>{{ $client->first_name }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Last Name</strong>
                                                        <p>{{ $client->last_name }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Gender</strong>
                                                        <p>{{ $client->gender ? ucfirst($client->gender) : 'Not specified' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Birthday</strong>
                                                        <p>{{ $client->birthday ? $client->birthday->format('F d, Y') : 'Not specified' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Pronouns</strong>
                                                        <p>{{ $client->pronouns ?: 'Not specified' }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Occupation</strong>
                                                        <p>{{ $client->occupation ?: 'Not specified' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="card shadow mb-4">
                                        <div class="card-header bg-success text-white py-3">
                                            <h6 class="mb-0">
                                                <i class="fa fa-info-circle me-2"></i>Additional Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Client Source</strong>
                                                        <p>{{ ucfirst(str_replace('-', ' ', $client->client_source)) }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Country</strong>
                                                        <p>{{ $client->country ?: 'Not specified' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <strong>Referred By</strong>
                                                        <p>
                                                            @if($client->referredBy)
                                                                {{ $client->referredBy->first_name }} {{ $client->referredBy->last_name }}
                                                            @else
                                                                Not referred
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Member Since</strong>
                                                        <p>{{ $client->created_at->format('F d, Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($client->notes)
                                            <div class="mb-3">
                                                <strong>Notes</strong>
                                                <p class="border rounded p-3 bg-light">{{ $client->notes }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quick Membership Overview -->
                                    @if($client->memberships->count() > 0)
                                    <div class="card shadow">
                                        <div class="card-header bg-primary text-white py-3">
                                            <h6 class="mb-0">
                                                <i class="fa fa-id-card me-2"></i>Active Memberships
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($client->activeMemberships as $membership)
                                                <div class="col-md-6 mb-3">
                                                    <div class="border rounded p-3 h-100">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <strong class="text-truncate">{{ $membership->membership->name }}</strong>
                                                            <span class="badge" style="background-color: {{ $membership->membership->color }}; color: white;">
                                                                Active
                                                            </span>
                                                        </div>
                                                        <p class="mb-1 small">
                                                            @if($membership->membership->session_type === 'limited')
                                                                Sessions: {{ $membership->sessions_used }}/{{ $membership->membership->session_count }}
                                                            @else
                                                                Unlimited Sessions
                                                            @endif
                                                        </p>
                                                        <p class="mb-1 small">Valid until: {{ $membership->end_date->format('M d, Y') }}</p>
                                                        <div class="mt-2">
                                                            <a href="#memberships" class="btn btn-sm btn-outline-primary" onclick="switchToTab('memberships-tab')">
                                                                Manage
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Memberships Tab -->
                        <div class="tab-pane fade" id="memberships" role="tabpanel">
                            @include('store.clients.memberships.index', ['client' => $client])
                        </div>

                        <!-- Addresses Tab -->
                        <div class="tab-pane fade" id="addresses" role="tabpanel">
                            <div class="row">
                                <!-- Addresses -->
                                <div class="col-md-6">
                                    <div class="card shadow h-100">
                                        <div class="card-header bg-primary text-white py-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fa fa-map-marker-alt me-2"></i>Addresses
                                                </h6>
                                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @forelse($client->addresses as $address)
                                            <div class="border rounded p-3 mb-3 position-relative">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <strong class="text-capitalize">{{ $address->type }}</strong>
                                                    <div>
                                                        @if($address->is_primary)
                                                        <span class="badge bg-primary me-1">Primary</span>
                                                        @endif
                                                        <form action="{{ route('store.clients.addresses.destroy', [$client, $address]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this address?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <p class="mb-1 small">{{ $address->address_line_1 }}</p>
                                                @if($address->address_line_2)
                                                <p class="mb-1 small">{{ $address->address_line_2 }}</p>
                                                @endif
                                                <p class="mb-1 small">{{ $address->city }}, {{ $address->region }} {{ $address->postcode }}</p>
                                                <p class="mb-0 small">{{ $address->country }}</p>
                                            </div>
                                            @empty
                                            <p class="text-muted text-center">No addresses added</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Emergency Contacts -->
                                <div class="col-md-6">
                                    <div class="card shadow h-100">
                                        <div class="card-header bg-warning text-dark py-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    <i class="fa fa-first-aid me-2"></i>Emergency Contacts
                                                </h6>
                                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addEmergencyContactModal">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @forelse($client->emergencyContacts as $contact)
                                            <div class="border rounded p-3 mb-3 position-relative">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <strong>{{ $contact->full_name }}</strong>
                                                    <div>
                                                        @if($contact->is_primary)
                                                        <span class="badge bg-warning text-dark me-1">Primary</span>
                                                        @endif
                                                        <form action="{{ route('store.clients.emergency-contacts.destroy', [$client, $contact]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Are you sure you want to delete this emergency contact?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <p class="mb-1 small"><i class="fa fa-phone me-1"></i>{{ $contact->phone }}</p>
                                                @if($contact->email)
                                                <p class="mb-1 small"><i class="fa fa-envelope me-1"></i>{{ $contact->email }}</p>
                                                @endif
                                                <p class="mb-0 small"><i class="fa fa-users me-1"></i>{{ $contact->relationship }}</p>
                                            </div>
                                            @empty
                                            <p class="text-muted text-center">No emergency contacts added</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('store.clients.addresses.store', $client) }}" method="POST" id="addressForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Address Type *</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select type</option>
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address_name" class="form-label">Address Name *</label>
                                <input type="text" class="form-control" id="address_name" name="address_name" 
                                       placeholder="e.g. Home, Office" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address_line_1" class="form-label">Address Line 1 *</label>
                        <input type="text" class="form-control" id="address_line_1" name="address_line_1" 
                               placeholder="Street address, P.O. box" required>
                    </div>

                    <div class="mb-3">
                        <label for="address_line_2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control" id="address_line_2" name="address_line_2" 
                               placeholder="Apartment, suite, unit, building, floor, etc.">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apt_suite" class="form-label">Apt./Suite etc</label>
                                <input type="text" class="form-control" id="apt_suite" name="apt_suite" 
                                       placeholder="Apt 123">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <input type="text" class="form-control" id="district" name="district" 
                                       placeholder="District name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" name="city" 
                                       placeholder="City name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="region" class="form-label">Region/State *</label>
                                <input type="text" class="form-control" id="region" name="region" 
                                       placeholder="State or region" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postcode" class="form-label">Postcode/ZIP *</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" 
                                       placeholder="Postal code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Select country</option>
                                    <option value="US">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="CA">Canada</option>
                                    <option value="AU">Australia</option>
                                    <option value="IN">India</option>
                                    <option value="DE">Germany</option>
                                    <option value="FR">France</option>
                                    <option value="JP">Japan</option>
                                    <option value="CN">China</option>
                                    <option value="BR">Brazil</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1">
                            <label class="form-check-label" for="is_primary">
                                Set as primary address
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Emergency Contact Modal -->
<div class="modal fade" id="addEmergencyContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Emergency Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('store.clients.emergency-contacts.store', $client) }}" method="POST" id="emergencyContactForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" 
                               placeholder="e.g. John Hancock" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="relationship" class="form-label">Relationship *</label>
                                <select class="form-select" id="relationship" name="relationship" required>
                                    <option value="">Select relationship</option>
                                    <option value="parent">Parent</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="partner">Partner</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="child">Child</option>
                                    <option value="friend">Friend</option>
                                    <option value="colleague">Colleague</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       placeholder="+1 234 567 8901" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="example@domain.com">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1">
                            <label class="form-check-label" for="is_primary">
                                Set as primary emergency contact
                            </label>
                        </div>
                    <small class="form-text text-muted">Primary contact will be used first in case of emergencies.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    font-weight: 600;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.border-rounded {
    border: 1px solid #e3f2fd;
    border-radius: 0.375rem;
}

.address-item, .contact-item {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.address-item:hover, .contact-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
    background: transparent;
}

.nav-tabs .nav-link:hover {
    border-color: transparent;
    color: #0d6efd;
}
</style>
@endpush

@push('scripts')
<script>
function switchToTab(tabId) {
    const tab = document.getElementById(tabId);
    if (tab) {
        const tabInstance = new bootstrap.Tab(tab);
        tabInstance.show();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Address Form Validation
    const addressForm = document.getElementById('addressForm');
    if (addressForm) {
        addressForm.addEventListener('submit', function(e) {
            const requiredFields = addressForm.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                const firstError = addressForm.querySelector('.is-invalid');
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        const addressInputs = addressForm.querySelectorAll('input, select');
        addressInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });
    }

    // Emergency Contact Form Validation
    const emergencyContactForm = document.getElementById('emergencyContactForm');
    if (emergencyContactForm) {
        emergencyContactForm.addEventListener('submit', function(e) {
            const requiredFields = emergencyContactForm.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                const firstError = emergencyContactForm.querySelector('.is-invalid');
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        const contactInputs = emergencyContactForm.querySelectorAll('input, select');
        contactInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });
    }

    // Clear form when modal is hidden
    const addressModal = document.getElementById('addAddressModal');
    const emergencyModal = document.getElementById('addEmergencyContactModal');

    if (addressModal) {
        addressModal.addEventListener('hidden.bs.modal', function () {
            addressForm.reset();
            const invalidFields = addressForm.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => field.classList.remove('is-invalid'));
        });
    }

    if (emergencyModal) {
        emergencyModal.addEventListener('hidden.bs.modal', function () {
            emergencyContactForm.reset();
            const invalidFields = emergencyContactForm.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => field.classList.remove('is-invalid'));
        });
    }
});

// Phone number formatting
function formatPhoneNumber(input) {
    let phone = input.value.replace(/\D/g, '');
    if (phone.length > 0) {
        phone = '+' + phone;
    }
    input.value = phone;
}

document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatPhoneNumber(this);
        });
    });
});
</script>
@endpush