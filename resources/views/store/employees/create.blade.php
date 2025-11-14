@extends('store.layouts.app')

@section('title', 'Create Employe')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone *</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Employment Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hire_date" class="form-label">Hire Date *</label>
                                            <input type="date" class="form-control" id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="employment_type" class="form-label">Employment Type *</label>
                                            <select class="form-control" id="employment_type" name="employment_type" required>
                                                <option value="full_time">Full Time</option>
                                                <option value="part_time">Part Time</option>
                                                <option value="contract">Contract</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Start Time *</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">End Time *</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', '17:00') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="salary_per_hour" class="form-label">Salary Per Hour ($) *</label>
                                    <input type="number" step="0.01" class="form-control" id="salary_per_hour" name="salary_per_hour" value="{{ old('salary_per_hour') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Working Days *</label>
                                    <div class="row">
                                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="{{ $day }}">
                                                <label class="form-check-label" for="{{ $day }}">
                                                    {{ ucfirst($day) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Emergency Contact</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="emergency_contact_name" class="form-label">Contact Name *</label>
                                            <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="emergency_contact_phone" class="form-label">Contact Phone *</label>
                                            <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Additional Information</h5>
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Specialization</label>
                                    <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="e.g., Hair Coloring, Beard Styling">
                                </div>

                                <div class="mb-3">
                                    <label for="bank_account_details" class="form-label">Bank Account Details</label>
                                    <textarea class="form-control" id="bank_account_details" name="bank_account_details" rows="2">{{ old('bank_account_details') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Services Provided</h5>
                                <div id="services-container">
                                    @if($services->count() > 0)
                                        @foreach($services as $service)
                                        <div class="row mb-2 service-row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}">
                                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                                        {{ $service->name }} (${{ number_format($service->price, 2) }} - {{ $service->duration_minutes }}min)
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Expertise Level (1-5)</label>
                                                <input type="number" class="form-control expertise-level" name="expertise_levels[]" min="1" max="5" value="3" disabled>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No services available. <a href="{{ route('store.services.create') }}">Create services first</a>.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create Employee</button>
                            <a href="{{ route('store.employees.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const expertiseInput = this.closest('.service-row').querySelector('.expertise-level');
            expertiseInput.disabled = !this.checked;
            if (!this.checked) {
                expertiseInput.value = '3';
            }
        });
    });
});
</script>
@endsection