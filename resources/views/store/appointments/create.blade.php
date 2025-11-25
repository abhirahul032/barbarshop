@extends('store.layouts.app')

@section('title', 'Create Appointment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Appointment</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.appointments.store') }}" method="POST" id="appointmentForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="team_member_id" class="form-label">Team Member *</label>
                                    <select name="team_member_id" id="team_member_id" class="form-select" required>
                                        <option value="">Select Team Member</option>
                                        @foreach($teamMembers as $member)
                                            <option value="{{ $member->id }}" 
                                                {{ old('team_member_id', request('team_member_id')) == $member->id ? 'selected' : '' }}>
                                                {{ $member->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_member_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
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
                                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} - ${{ number_format($service->price, 2) }} ({{ $service->formatted_duration }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Date *</label>
                                    <input type="date" name="appointment_date" id="appointment_date" 
                                           class="form-control" value="{{ old('appointment_date', request('date')) }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('appointment_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Time *</label>
                                    <select name="start_time" id="start_time" class="form-select" required>
                                        <option value="">Select Time</option>
                                    </select>
                                    @error('start_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">Client Name *</label>
                                    <input type="text" name="client_name" id="client_name" 
                                           class="form-control" value="{{ old('client_name') }}" required>
                                    @error('client_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_email" class="form-label">Client Email *</label>
                                    <input type="email" name="client_email" id="client_email" 
                                           class="form-control" value="{{ old('client_email') }}" required>
                                    @error('client_email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_phone" class="form-label">Client Phone</label>
                                    <input type="text" name="client_phone" id="client_phone" 
                                           class="form-control" value="{{ old('client_phone') }}">
                                    @error('client_phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="client_notes" class="form-label">Client Notes</label>
                            <textarea name="client_notes" id="client_notes" class="form-control" 
                                      rows="3">{{ old('client_notes') }}</textarea>
                            @error('client_notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Internal Notes</label>
                            <textarea name="notes" id="notes" class="form-control" 
                                      rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('store.appointments.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Appointment Summary</h6>
                </div>
                <div class="card-body">
                    <div id="appointmentSummary" class="text-muted">
                        <p class="mb-2">Select a team member, service, date, and time to see details.</p>
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
    const summaryDiv = document.getElementById('appointmentSummary');

    function updateAvailableSlots() {
        const teamMemberId = teamMemberSelect.value;
        const serviceId = serviceSelect.value;
        const date = dateInput.value;

        if (!teamMemberId || !serviceId || !date) {
            timeSelect.innerHTML = '<option value="">Select Time</option>';
            return;
        }

        // Show loading
        timeSelect.innerHTML = '<option value="">Loading available slots...</option>';

        fetch(`{{ route('store.appointments.available-slots') }}?team_member_id=${teamMemberId}&service_id=${serviceId}&date=${date}`)
            .then(response => response.json())
            .then(slots => {
                timeSelect.innerHTML = '<option value="">Select Time</option>';
                slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.start;
                    option.textContent = slot.formatted;
                    timeSelect.appendChild(option);
                });

                if (slots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No available slots</option>';
                }
            })
            .catch(error => {
                console.error('Error fetching slots:', error);
                timeSelect.innerHTML = '<option value="">Error loading slots</option>';
            });
    }

    function updateSummary() {
        const teamMember = teamMemberSelect.options[teamMemberSelect.selectedIndex]?.text;
        const service = serviceSelect.options[serviceSelect.selectedIndex];
        const date = dateInput.value;
        const time = timeSelect.options[timeSelect.selectedIndex]?.text;

        if (teamMember && service && date && time) {
            const duration = service.getAttribute('data-duration');
            const price = service.getAttribute('data-price');
            
            summaryDiv.innerHTML = `
                <div class="mb-2">
                    <strong>Team Member:</strong><br>
                    ${teamMember}
                </div>
                <div class="mb-2">
                    <strong>Service:</strong><br>
                    ${service.text}
                </div>
                <div class="mb-2">
                    <strong>Date & Time:</strong><br>
                    ${new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}<br>
                    ${time}
                </div>
                <div class="mb-2">
                    <strong>Duration:</strong> ${duration} minutes
                </div>
                <div class="mb-2">
                    <strong>Price:</strong> $${parseFloat(price).toFixed(2)}
                </div>
            `;
        } else {
            summaryDiv.innerHTML = '<p class="mb-2">Select a team member, service, date, and time to see details.</p>';
        }
    }

    // Event listeners
    teamMemberSelect.addEventListener('change', function() {
        updateAvailableSlots();
        updateSummary();
    });

    serviceSelect.addEventListener('change', function() {
        updateAvailableSlots();
        updateSummary();
    });

    dateInput.addEventListener('change', function() {
        updateAvailableSlots();
        updateSummary();
    });

    timeSelect.addEventListener('change', updateSummary);

    // Initialize summary if there are existing values
    updateSummary();
});
</script>
@endpush