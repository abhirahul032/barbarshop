@extends('store.layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone *</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 

                                                   value="{{ old('date_of_birth', \Carbon\Carbon::parse($employee->start_time)->format('Y-m-d')) }}"
                                                   
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                            @if($employee->photo)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $employee->photo) }}" width="100" height="100" style="object-fit: cover;" alt="Current photo">
                                                    <p class="text-muted small">Current photo</p>
                                                </div>
                                            @endif
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
                                            <input type="date" class="form-control" id="hire_date" name="hire_date" 
                                                  
                                                   value="{{ old('hire_date', \Carbon\Carbon::parse($employee->start_time)->format('Y-m-d')) }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="employment_type" class="form-label">Employment Type *</label>
                                            <select class="form-control" id="employment_type" name="employment_type" required>
                                                <option value="full_time" {{ old('employment_type', $employee->employment_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="part_time" {{ old('employment_type', $employee->employment_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                                <option value="contract" {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Start Time *</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($employee->start_time)->format('H:i')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">End Time *</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($employee->end_time)->format('H:i')) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="salary_per_hour" class="form-label">Salary Per Hour ($) *</label>
                                    <input type="number" step="0.01" class="form-control" id="salary_per_hour" name="salary_per_hour" value="{{ old('salary_per_hour', $employee->salary_per_hour) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Working Days *</label>
                                    <div class="row">
                                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="{{ $day }}" 
                                                    {{ in_array($day, old('working_days', $employee->working_days ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $day }}">
                                                    {{ ucfirst($day) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ old('status', $employee->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
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
                                            <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="emergency_contact_phone" class="form-label">Contact Phone *</label>
                                            <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Additional Information</h5>
                                <div class="mb-3">
                                    <label for="specialization" class="form-label">Specialization</label>
                                    <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization', $employee->specialization) }}" placeholder="e.g., Hair Coloring, Beard Styling">
                                </div>

                                <div class="mb-3">
                                    <label for="bank_account_details" class="form-label">Bank Account Details</label>
                                    <textarea class="form-control" id="bank_account_details" name="bank_account_details" rows="2">{{ old('bank_account_details', $employee->bank_account_details) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Services Provided Section -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Services Provided</h5>
                                <div id="services-container">
                                    @if($services->count() > 0)
                                        @foreach($services as $service)
                                        <div class="row mb-2 service-row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    @php
                                                        $employeeService = $employee->services->where('id', $service->id)->first();
                                                        $isChecked = $employeeService ? 'checked' : '';
                                                        $expertiseLevel = $employeeService ? $employeeService->pivot->expertise_level : 3;
                                                    @endphp
                                                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]" value="{{ $service->id }}" id="service_{{ $service->id }}" {{ $isChecked }}>
                                                    <label class="form-check-label" for="service_{{ $service->id }}">
                                                        {{ $service->name }} (${{ number_format($service->price, 2) }} - {{ $service->duration_minutes }}min)
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Expertise Level (1-5)</label>
                                                <input type="number" class="form-control expertise-level" name="expertise_levels[]" min="1" max="5" value="{{ $expertiseLevel }}" {{ $isChecked ? '' : 'disabled' }}>
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
                            <button type="submit" class="btn btn-primary">Update Employee</button>
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