@extends('store.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Scheduled Shifts</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addShiftModal">
                        <i class="fa fa-plus me-2"></i>Add Shift
                    </button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addBulkShiftModal">
                        <i class="fa fa-layer-group me-2"></i>Add Multiple Shifts
                    </button>
                    <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#repeatingShiftModal">
                        <i class="fa fa-repeat me-2"></i>Set Repeating Shifts
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $weekStart->format('M j, Y') }} - {{ $weekEnd->format('M j, Y') }}</h5>
                            <small class="text-muted">This week: {{ $weekStart->format('M j') }} - {{ $weekEnd->format('M j, Y') }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('store.scheduled-shifts.index', ['week_start' => $weekStart->copy()->subWeek()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fa fa-chevron-left"></i> Previous Week
                            </a>
                            <a href="{{ route('store.scheduled-shifts.index', ['week_start' => now()->startOfWeek()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-secondary">Current Week</a>
                            <a href="{{ route('store.scheduled-shifts.index', ['week_start' => $weekStart->copy()->addWeek()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-secondary">
                                Next Week <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shifts Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="200">Team member</th>
                                    @foreach($weekDays as $day)
                                    <th class="text-center">
                                        <div>{{ $day->format('D') }}</div>
                                        <div class="text-muted small">{{ $day->format('M j') }}</div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teamMembers as $teamMember)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($teamMember->profile_picture)
                                              <img src="{{ asset('storage/' . $teamMember->profile_picture) }}" alt="{{ $teamMember->full_name }}" class="rounded-circle" style="width:56px;height:56px;object-fit:cover;" />
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; background-color: {{ $teamMember->calendar_color }} !important;">
                                                    {{ substr($teamMember->first_name, 0, 1) }}{{ substr($teamMember->last_name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $teamMember->first_name }} {{ $teamMember->last_name }}</strong>
                                                @if($teamMember->job_title)
                                                    <br><small class="text-muted">{{ $teamMember->job_title }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($weekDays as $day)
                                    <td class="position-relative" style="min-height: 80px;">
                                        @php
                                            $dayShifts = $teamMember->scheduledShifts->where('shift_date', $day->format('Y-m-d'));
                                            $dayShifts = $teamMember->scheduledShifts()->whereDate('shift_date', $day->format('Y-m-d'))->get()  
                                        @endphp
                                        
                                        @foreach($dayShifts as $shift)
                                        <div class="shift-item mb-1 p-2 rounded border" 
                                             data-shift-id="{{ $shift->id }}"
                                             style="background-color: {{ $shift->shift_type === 'overtime' ? '#fff3cd' : ($shift->shift_type === 'holiday' ? '#d1ecf1' : '#e7f3ff') }}; border-color: {{ $shift->shift_type === 'overtime' ? '#ffeaa7' : ($shift->shift_type === 'holiday' ? '#bee5eb' : '#b3d7ff') }} !important;">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <small class="fw-bold">{{ $shift->formatted_shift }}</small>
                                                    @if($shift->notes)
                                                        <br><small class="text-muted">{{ Str::limit($shift->notes, 20) }}</small>
                                                    @endif
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-link text-dark p-0" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item edit-shift" 
                                                                    data-shift-id="{{ $shift->id }}">
                                                                <i class="fa fa-edit me-2"></i>Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item delete-shift" 
                                                                    data-shift-id="{{ $shift->id }}">
                                                                <i class="fa fa-trash me-2"></i>Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        @if($dayShifts->isEmpty())
                                        <div class="text-center text-muted py-3">
                                            <small>No shift</small>
                                        </div>
                                        @endif
                                        
                                        <button class="btn btn-sm btn-outline-secondary w-100 add-shift-btn" 
                                                data-team-member-id="{{ $teamMember->id }}"
                                                data-shift-date="{{ $day->format('Y-m-d') }}"
                                                style="position: absolute; bottom: 5px; left: 5px; right: 5px;">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Text -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-info">
                <small>
                    <i class="fa fa-info-circle me-2"></i>
                    The team roster shows your availability for bookings and is not linked to your business standard opening hours. 
                    To set your standard opening hours, <a href="#" class="alert-link">click here</a>.
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Add Shift Modal -->
@include('store.scheduled-shifts.partials.add-shift-modal')
<!-- Bulk Add Shifts Modal -->
@include('store.scheduled-shifts.partials.bulk-shift-modal')
<!-- Repeating Shift Modal -->
@include('store.scheduled-shifts.partials.repeating-shift-modal')
<!-- Edit Shift Modal -->
@include('store.scheduled-shifts.partials.edit-shift-modal')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Shift functionality
    document.querySelectorAll('.add-shift-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const teamMemberId = this.dataset.teamMemberId;
            const shiftDate = this.dataset.shiftDate;
            
            document.getElementById('team_member_id').value = teamMemberId;
            document.getElementById('shift_date').value = shiftDate;
            
            const modal = new bootstrap.Modal(document.getElementById('addShiftModal'));
            modal.show();
        });
    });

    // Edit Shift functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-shift') || e.target.closest('.edit-shift')) {
            const button = e.target.classList.contains('edit-shift') ? e.target : e.target.closest('.edit-shift');
            const shiftId = button.dataset.shiftId;
            
            fetchShiftData(shiftId);
        }
        
        if (e.target.classList.contains('delete-shift') || e.target.closest('.delete-shift')) {
            const button = e.target.classList.contains('delete-shift') ? e.target : e.target.closest('.delete-shift');
            const shiftId = button.dataset.shiftId;
            
            if (confirm('Are you sure you want to delete this shift?')) {
                deleteShift(shiftId);
            }
        }
    });

    function fetchShiftData(shiftId) {
        // Use the named route for edit
        fetch(`{{ route('store.scheduled-shifts.edit', '') }}/${shiftId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    populateEditForm(data.data);
                    const modal = new bootstrap.Modal(document.getElementById('editShiftModal'));
                    modal.show();
                } else {
                    alert('Error fetching shift data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error fetching shift data. Please try again.');
            });
    }

    function populateEditForm(shift) {
        document.getElementById('edit_shift_id').value = shift.id;
        document.getElementById('edit_shift_date').value = shift.shift_date;
        document.getElementById('edit_start_time').value = shift.start_time;
        document.getElementById('edit_end_time').value = shift.end_time;
        document.getElementById('edit_shift_type').value = shift.shift_type;
        document.getElementById('edit_notes').value = shift.notes || '';
    }

    function deleteShift(shiftId) {
        // Use the named route for destroy
        fetch(`{{ route('store.scheduled-shifts.destroy', '') }}/${shiftId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting shift: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting shift. Please try again.');
        });
    }

    // Add Shift Form Submission
    document.getElementById('addShiftForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("store.scheduled-shifts.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error adding shift: ' + data.message);
            if (data.errors) {
                console.error('Validation errors:', data.errors);
            }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding shift. Please try again.');
        });
    });

    // Edit Shift Form Submission
    document.getElementById('editShiftForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const shiftId = document.getElementById('edit_shift_id').value;
        const formData = new FormData(this);
        
        // Use the named route for update
        fetch(`{{ route('store.scheduled-shifts.update', '') }}/${shiftId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating shift: ' + data.message);
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating shift. Please try again.');
        });
    });
});
</script>
@endpush