<div class="modal fade" id="addBulkShiftModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Multiple Shifts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBulkShiftForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Team Members</label>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 0.75rem;">
                                    @foreach($teamMembers as $member)
                                    <div class="form-check">
                                        <input class="form-check-input team-member-checkbox" type="checkbox" 
                                               name="team_member_ids[]" value="{{ $member->id }}" id="member_{{ $member->id }}">
                                        <label class="form-check-label" for="member_{{ $member->id }}">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                            @if($member->job_title)
                                                <small class="text-muted">({{ $member->job_title }})</small>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllMembers">
                                        Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllMembers">
                                        Deselect All
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dates</label>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 0.75rem;">
                                    @foreach($weekDays as $day)
                                    <div class="form-check">
                                        <input class="form-check-input date-checkbox" type="checkbox" 
                                               name="shift_dates[]" value="{{ $day->format('Y-m-d') }}" id="date_{{ $day->format('Y-m-d') }}">
                                        <label class="form-check-label" for="date_{{ $day->format('Y-m-d') }}">
                                            {{ $day->format('D, M j') }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllDates">
                                        Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllDates">
                                        Deselect All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bulk_start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="bulk_start_time" name="start_time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bulk_end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="bulk_end_time" name="end_time" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bulk_shift_type" class="form-label">Shift Type</label>
                        <select class="form-select" id="bulk_shift_type" name="shift_type" required>
                            <option value="regular">Regular</option>
                            <option value="overtime">Overtime</option>
                            <option value="holiday">Holiday</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="fa fa-info-circle me-2"></i>
                            This will create shifts for all selected team members on all selected dates.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Shifts</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select/Deselect All functionality for team members
    document.getElementById('selectAllMembers').addEventListener('click', function() {
        document.querySelectorAll('.team-member-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    });
    
    document.getElementById('deselectAllMembers').addEventListener('click', function() {
        document.querySelectorAll('.team-member-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
    
    // Select/Deselect All functionality for dates
    document.getElementById('selectAllDates').addEventListener('click', function() {
        document.querySelectorAll('.date-checkbox').forEach(checkbox => {
            checkbox.checked = true;
        });
    });
    
    document.getElementById('deselectAllDates').addEventListener('click', function() {
        document.querySelectorAll('.date-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });
    });
    
    // Bulk form submission
    document.getElementById('addBulkShiftForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedMembers = document.querySelectorAll('.team-member-checkbox:checked');
        const selectedDates = document.querySelectorAll('.date-checkbox:checked');
        
        if (selectedMembers.length === 0) {
            alert('Please select at least one team member.');
            return;
        }
        
        if (selectedDates.length === 0) {
            alert('Please select at least one date.');
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('{{ route("store.scheduled-shifts.bulk.store") }}', {
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
                alert('Error adding shifts: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>