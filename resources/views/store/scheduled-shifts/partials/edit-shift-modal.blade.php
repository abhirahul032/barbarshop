<div class="modal fade" id="editShiftModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editShiftForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_shift_id" name="shift_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_shift_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="edit_shift_date" name="shift_date" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="edit_start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="edit_end_time" name="end_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_shift_type" class="form-label">Shift Type</label>
                        <select class="form-select" id="edit_shift_type" name="shift_type" required>
                            <option value="regular">Regular</option>
                            <option value="overtime">Overtime</option>
                            <option value="holiday">Holiday</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Shift</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('editShiftForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const shiftId = document.getElementById('edit_shift_id').value;
    const formData = new FormData(this);
    
    fetch(`/store/scheduled-shifts/${shiftId}`, {
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
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>