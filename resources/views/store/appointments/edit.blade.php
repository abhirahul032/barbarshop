@extends('store.layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Appointment - {{ $appointment->appointment_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.appointments.update', $appointment) }}" method="POST" id="appointmentForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="team_member_id" class="form-label">Team Member *</label>
                                    <select name="team_member_id" id="team_member_id" class="form-select" required>
                                        <option value="">Select Team Member</option>
                                        @foreach($teamMembers as $member)
                                            <option value="{{ $member->id }}" 
                                                {{ old('team_member_id', $appointment->team_member_id) == $member->id ? 'selected' : '' }}>
                                                {{ $member->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_id" class="form-label">Service *</label>
                                    <select name="service_id" id="service_id" class="form-select" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $category => $categoryServices)
                                            <optgroup label="{{ ucfirst($category) }}">
                                                @foreach($categoryServices as $service)
                                                    <option value="{{ $service->id }}" 
                                                        data-duration="{{ $service->duration_minutes }}"
                                                        data-price="{{ $service->price }}"
                                                        {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} - ${{ number_format($service->price, 2) }} ({{ $service->formatted_duration }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Date *</label>
                                    <input type="date" name="appointment_date" id="appointment_date" 
                                           class="form-control" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Time *</label>
                                    <select name="start_time" id="start_time" class="form-select" required>
                                        <option value="">Select Time</option>
                                        <option value="{{ $appointment->start_time->format('H:i') }}" selected>
                                            {{ $appointment->formatted_start_time }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">Client Name *</label>
                                    <input type="text" name="client_name" id="client_name" 
                                           class="form-control" value="{{ old('client_name', $appointment->client_name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_email" class="form-label">Client Email *</label>
                                    <input type="email" name="client_email" id="client_email" 
                                           class="form-control" value="{{ old('client_email', $appointment->client_email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_phone" class="form-label">Client Phone</label>
                                    <input type="text" name="client_phone" id="client_phone" 
                                           class="form-control" value="{{ old('client_phone', $appointment->client_phone) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="scheduled" {{ old('status', $appointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="no_show" {{ old('status', $appointment->status) == 'no_show' ? 'selected' : '' }}>No Show</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="client_notes" class="form-label">Client Notes</label>
                            <textarea name="client_notes" id="client_notes" class="form-control" rows="3">{{ old('client_notes', $appointment->client_notes) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Internal Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('store.appointments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Appointment Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Appointment Number:</strong><br>
                        {{ $appointment->appointment_number }}
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        {{ $appointment->created_at->format('M j, Y g:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        {{ $appointment->updated_at->format('M j, Y g:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Commission:</strong><br>
                        ${{ number_format($appointment->commission_amount, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const teamMemberSelect = document.getElementById('team_member_id');
    const serviceSelect = document.getElementById('service_id');
    const dateInput = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('start_time');
    
    // Store the original time
    const originalTime = '{{ $appointment->start_time->format("H:i") }}';
    const originalTimeFormatted = '{{ $appointment->formatted_start_time }}';

    function updateAvailableSlots() {
        const teamMemberId = teamMemberSelect.value;
        const serviceId = serviceSelect.value;
        const date = dateInput.value;

        if (!teamMemberId || !serviceId || !date) {
            timeSelect.innerHTML = `<option value="">Select Time</option><option value="${originalTime}" selected>${originalTimeFormatted}</option>`;
            return;
        }

        // Show loading
        timeSelect.innerHTML = '<option value="">Loading available slots...</option>';

        fetch(`{{ route('store.appointments.available-slots') }}?team_member_id=${teamMemberId}&service_id=${serviceId}&date=${date}`)
            .then(response => response.json())
            .then(slots => {
                timeSelect.innerHTML = '<option value="">Select Time</option>';
                
                let originalTimeSelected = false;
                
                // Add available slots
                slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.start;
                    option.textContent = slot.formatted;
                    
                    // Select if it matches original time
                    if (slot.start === originalTime) {
                        option.selected = true;
                        originalTimeSelected = true;
                    }
                    
                    timeSelect.appendChild(option);
                });

                // If original time not found in available slots, add it and select it
                if (!originalTimeSelected && originalTime) {
                    const originalOption = document.createElement('option');
                    originalOption.value = originalTime;
                    originalOption.textContent = originalTimeFormatted;
                    originalOption.selected = true;
                    timeSelect.appendChild(originalOption);
                }

                // If no slots available and no original time, show message
                if (slots.length === 0 && !originalTime) {
                    timeSelect.innerHTML = '<option value="">No available slots</option>';
                }
            })
            .catch(error => {
                console.error('Error fetching slots:', error);
                // On error, restore the original time
                timeSelect.innerHTML = `<option value="">Error loading slots</option><option value="${originalTime}" selected>${originalTimeFormatted}</option>`;
            });
    }

    // Event listeners for dynamic slot loading
    teamMemberSelect.addEventListener('change', updateAvailableSlots);
    serviceSelect.addEventListener('change', updateAvailableSlots);
    dateInput.addEventListener('change', updateAvailableSlots);

    // Initialize slots on page load
    updateAvailableSlots();
});
</script>
@endpush