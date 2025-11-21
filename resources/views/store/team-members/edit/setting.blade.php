<!-- Settings Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Settings</h5>
    </div>
    <div class="section-body">
        <!-- Appointment Settings -->
        <div class="mb-4">
            <h6>Appointment settings</h6>
            <p class="text-muted">Choose if this team member is bookable on the calendar</p>
            
            <div class="form-check">
                <input class="form-check-input settings-field" type="checkbox" id="allow_bookings" name="allow_bookings" value="1" 
                    {{ (isset($teamMember) && $teamMember->allow_bookings) ? 'checked' : 'checked' }}>
                <label class="form-check-label" for="allow_bookings">
                    Allow calendar bookings<br>
                    <small class="text-muted">Allow this team member to receive bookings on the calendar</small>
                </label>
            </div>
            
            <div class="alert alert-info mt-2">
                <small>You'll be billed ?258.95 per month for each bookable team member in this workspace.</small>
            </div>
        </div>

        <!-- Permission Level -->
        <div class="mb-4">
            <h6>Permission level</h6>
            <p class="text-muted">Choose the access level this team member has to the workspace</p>
            
            <select class="form-select settings-field" id="permission_level" name="permission_level">
                <option value="no_access" {{ (isset($teamMember) && $teamMember->permission_level == 'no_access') ? 'selected' : '' }}>No access</option>
                <option value="low" {{ (isset($teamMember) && $teamMember->permission_level == 'low') ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ (isset($teamMember) && $teamMember->permission_level == 'medium') ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ (isset($teamMember) && $teamMember->permission_level == 'high') ? 'selected' : '' }}>High</option>
                <option value="admin" {{ (isset($teamMember) && $teamMember->permission_level == 'admin') ? 'selected' : '' }}>Admin</option>
            </select>
            <small class="text-muted">The access level this team member has to the workspace</small>
        </div>

        <!-- Auto-save indicator -->
        <div id="settingsSaveStatus" class="d-flex justify-content-end mt-3">
            <small class="text-muted" id="saveStatusText">Changes saved automatically</small>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let saveTimeout;
    
    // Auto-save settings when fields change
    $('.settings-field').on('change', function() {
        clearTimeout(saveTimeout);
        
        $('#saveStatusText').text('Saving...').removeClass('text-muted text-success text-danger').addClass('text-warning');
        
        saveTimeout = setTimeout(function() {
            saveSettings();
        }, 1000);
    });
    
    function saveSettings() {
        const formData = {
            allow_bookings: $('#allow_bookings').is(':checked') ? 1 : 0,
            permission_level: $('#permission_level').val(),
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };
        
        $.ajax({
            url: '{{ route("store.team-members.update-settings", $teamMember) }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#saveStatusText').text('Settings saved!').removeClass('text-warning text-danger text-muted').addClass('text-success');
                
                // Revert to muted after 2 seconds
                setTimeout(function() {
                    $('#saveStatusText').text('Changes saved automatically').removeClass('text-success').addClass('text-muted');
                }, 2000);
            },
            error: function(xhr) {
                $('#saveStatusText').text('Error saving settings').removeClass('text-warning text-success text-muted').addClass('text-danger');
                
                // Revert to muted after 3 seconds
                setTimeout(function() {
                    $('#saveStatusText').text('Changes saved automatically').removeClass('text-danger').addClass('text-muted');
                }, 3000);
            }
        });
    }
});
</script>
@endpush