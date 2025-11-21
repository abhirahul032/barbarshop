<div class="modal fade" id="repeatingShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Repeating Shifts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="repeatingShiftForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="repeat_team_member_id" class="form-label">Team Member</label>
                        <select class="form-select" id="repeat_team_member_id" name="team_member_id" required>
                            <option value="">Select Team Member</option>
                            @foreach($teamMembers as $member)
                                <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repeat_start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="repeat_start_date" name="shift_date" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="repeat_start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="repeat_start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="repeat_end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="repeat_end_time" name="end_time" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repeat_shift_type" class="form-label">Shift Type</label>
                        <select class="form-select" id="repeat_shift_type" name="shift_type" required>
                            <option value="regular">Regular</option>
                            <option value="overtime">Overtime</option>
                            <option value="holiday">Holiday</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repeat_frequency" class="form-label">Repeat Every</label>
                        <select class="form-select" id="repeat_frequency" name="repeat_frequency" required>
                            <option value="weekly">Weekly</option>
                            <option value="bi_weekly">Every 2 Weeks</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repeat_until" class="form-label">Repeat Until</label>
                        <input type="date" class="form-control" id="repeat_until" name="repeat_until" required>
                        <div class="form-text">Shifts will be created until this date (inclusive)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="repeat_notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="repeat_notes" name="notes" rows="3"></textarea>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_repeating" name="is_repeating" value="1" checked>
                        <label class="form-check-label" for="is_repeating">
                            Enable repeating shifts
                        </label>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="fa fa-info-circle me-2"></i>
                            This will create recurring shifts based on the selected frequency until the end date.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Repeating Shifts</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default dates for repeating shifts
    const today = new Date();
    const nextMonth = new Date(today);
    nextMonth.setMonth(today.getMonth() + 1);
    
    document.getElementById('repeat_start_date').value = today.toISOString().split('T')[0];
    document.getElementById('repeat_until').value = nextMonth.toISOString().split('T')[0];
    
    // Repeating shift form submission
    document.getElementById('repeatingShiftForm').addEventListener('submit', function(e) {
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
                alert('Error creating repeating shifts: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>