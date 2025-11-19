
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
                <input class="form-check-input" type="checkbox" id="allow_bookings" name="allow_bookings" value="1" checked>
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
            
            <select class="form-select" id="permission_level" name="permission_level">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="admin">Admin</option>
            </select>
            <small class="text-muted">The access level this team member has to the workspace</small>
        </div>
    </div>
</div>