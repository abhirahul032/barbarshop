{{-- resources/views/store/memberships/edit.blade.php --}}
@extends('store.layouts.app')

@section('title', 'Edit Membership')

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
                <h4 class="page-title">Edit Membership</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('store.memberships.update', $membership) }}" method="POST" id="membershipForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Left Column - Basic Info -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Basic Information</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Membership Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $membership->name) }}" required maxlength="255">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" maxlength="360">{{ old('description', $membership->description) }}</textarea>
                            <div class="form-text">
                                <span id="description-counter">0</span>/360 characters
                            </div>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Color Customization</label>
                            <div class="color-picker">
                                @php
                                    $colors = ['#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899'];
                                @endphp
                                @foreach($colors as $color)
                                    <div class="color-option">
                                        <input type="radio" name="color" value="{{ $color }}" 
                                               id="color-{{ $loop->index }}" 
                                               {{ old('color', $membership->color) === $color ? 'checked' : '' }}>
                                        <label for="color-{{ $loop->index }}" 
                                               style="background-color: {{ $color }}"></label>
                                    </div>
                                @endforeach
                            </div>
                            @error('color')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Select Services</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="service-search" 
                                       placeholder="Search services...">
                            </div>
                            <div class="col-md-6">
                                <select class="form-select" id="category-filter">
                                    <option value="all">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="services-list" style="max-height: 400px; overflow-y: auto;">
                            @foreach($services as $service)
                                <div class="service-item mb-2 p-2 border rounded" 
                                     data-category="{{ $service->category }}"
                                     data-name="{{ strtolower($service->name) }}">
                                    <div class="form-check">
                                        <input class="form-check-input service-checkbox" 
                                               type="checkbox" 
                                               name="services[]" 
                                               value="{{ $service->id }}"
                                               id="service-{{ $service->id }}"
                                               {{ in_array($service->id, $selectedServices) ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="service-{{ $service->id }}">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $service->name }}</span>
                                                <span class="text-muted">${{ number_format($service->price, 2) }}</span>
                                            </div>
                                            <small class="text-muted">{{ $service->category }}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                Selected <span id="selected-count">0</span> services
                            </small>
                        </div>
                        @error('services')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Terms & Conditions</h5>
                        <textarea class="form-control" name="terms_conditions" 
                                  rows="4" placeholder="Add terms and conditions (optional)" 
                                  maxlength="3000">{{ old('terms_conditions', $membership->terms_conditions) }}</textarea>
                        <div class="form-text">
                            <span id="terms-counter">0</span>/3000 characters
                        </div>
                        @error('terms_conditions')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column - Settings -->
            <div class="col-lg-4">
                <!-- Sessions & Pricing -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sessions and Pricing</h5>

                        <div class="mb-3">
                            <label class="form-label">Sessions</label>
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-select" name="session_type" id="session-type">
                                        <option value="limited" {{ old('session_type', $membership->session_type) === 'limited' ? 'selected' : '' }}>Limited</option>
                                        <option value="unlimited" {{ old('session_type', $membership->session_type) === 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                                    </select>
                                </div>
                                <div class="col-6" id="session-count-container">
                                    <input type="number" class="form-control" name="session_count" 
                                           value="{{ old('session_count', $membership->session_count) }}" min="1" 
                                           id="session-count">
                                </div>
                            </div>
                            @error('session_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('session_count')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Valid for</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="validity_duration" 
                                           value="{{ old('validity_duration', $membership->validity_duration) }}" min="1" required>
                                </div>
                                <div class="col-6">
                                    <select class="form-select" name="validity_period" required>
                                        <option value="days" {{ old('validity_period', $membership->validity_period) === 'days' ? 'selected' : '' }}>Days</option>
                                        <option value="weeks" {{ old('validity_period', $membership->validity_period) === 'weeks' ? 'selected' : '' }}>Weeks</option>
                                        <option value="months" {{ old('validity_period', $membership->validity_period) === 'months' ? 'selected' : '' }}>Months</option>
                                        <option value="years" {{ old('validity_period', $membership->validity_period) === 'years' ? 'selected' : '' }}>Years</option>
                                    </select>
                                </div>
                            </div>
                            @error('validity_duration')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('validity_period')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $membership->price) }}" step="0.01" min="0" required>
                            </div>
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tax_rate_id" class="form-label">Tax Rate</label>
                            <select class="form-select" name="tax_rate_id" id="tax_rate_id">
                                <option value="">No tax</option>
                                @foreach($taxRates as $taxRate)
                                    <option value="{{ $taxRate->id }}" 
                                            {{ old('tax_rate_id', $membership->tax_rate_id) == $taxRate->id ? 'selected' : '' }}>
                                        {{ $taxRate->name }} ({{ $taxRate->rate }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('tax_rate_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Online Settings -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Online Sales & Redemption</h5>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                   name="online_sales_enabled" value="1" 
                                   id="online_sales" {{ old('online_sales_enabled', $membership->online_sales_enabled) ? 'checked' : '' }}>
                            <label class="form-check-label" for="online_sales">
                                Enable online sales
                            </label>
                            <div class="form-text">
                                Clients can purchase this membership online
                            </div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="online_redemption_enabled" value="1" 
                                   id="online_redemption" {{ old('online_redemption_enabled', $membership->online_redemption_enabled) ? 'checked' : '' }}>
                            <label class="form-check-label" for="online_redemption">
                                Enable online redemption
                            </label>
                            <div class="form-text">
                                Clients can use this membership to book services online
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <small>
                                <i class="fa fainfo-circle me-1"></i>
                                Online membership sales are coming soon to India with payments in Fresha
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card mt-3">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            Update Membership
                        </button>
                        <a href="{{ route('store.memberships.index') }}" class="btn btn-secondary w-100">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    const description = document.getElementById('description');
    const descriptionCounter = document.getElementById('description-counter');
    const terms = document.querySelector('[name="terms_conditions"]');
    const termsCounter = document.getElementById('terms-counter');

    description.addEventListener('input', () => {
        descriptionCounter.textContent = description.value.length;
    });

    terms.addEventListener('input', () => {
        termsCounter.textContent = terms.value.length;
    });

    // Initialize counters
    descriptionCounter.textContent = description.value.length;
    termsCounter.textContent = terms.value.length;

    // Session type toggle
    const sessionType = document.getElementById('session-type');
    const sessionCountContainer = document.getElementById('session-count-container');
    
    function toggleSessionCount() {
        if (sessionType.value === 'unlimited') {
            sessionCountContainer.style.display = 'none';
            document.getElementById('session-count').disabled = true;
        } else {
            sessionCountContainer.style.display = 'block';
            document.getElementById('session-count').disabled = false;
        }
    }
    
    sessionType.addEventListener('change', toggleSessionCount);
    toggleSessionCount(); // Initial call

    // Service search and filter
    const serviceSearch = document.getElementById('service-search');
    const categoryFilter = document.getElementById('category-filter');
    const serviceItems = document.querySelectorAll('.service-item');
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const selectedCount = document.getElementById('selected-count');

    function filterServices() {
        const searchTerm = serviceSearch.value.toLowerCase();
        const category = categoryFilter.value;

        serviceItems.forEach(item => {
            const matchesSearch = item.dataset.name.includes(searchTerm);
            const matchesCategory = category === 'all' || item.dataset.category === category;
            
            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function updateSelectedCount() {
        const selected = document.querySelectorAll('.service-checkbox:checked').length;
        selectedCount.textContent = selected;
    }

    serviceSearch.addEventListener('input', filterServices);
    categoryFilter.addEventListener('change', filterServices);
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    updateSelectedCount(); // Initial count

    // Form validation
    document.getElementById('membershipForm').addEventListener('submit', function(e) {
        const selectedServices = document.querySelectorAll('.service-checkbox:checked').length;
        if (selectedServices === 0) {
            e.preventDefault();
            alert('Please select at least one service.');
            return false;
        }
    });
});
</script>

<style>
.color-picker {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.color-option {
    position: relative;
}

.color-option input[type="radio"] {
    display: none;
}

.color-option label {
    display: block;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid transparent;
    transition: border-color 0.2s;
}

.color-option input[type="radio"]:checked + label {
    border-color: #333;
}

.service-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush