<!-- resources/views/team-members/partials/wages.blade.php -->

<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Wages and timesheets</h5>
        <small class="text-muted">Set up how much this team member earns. <a href="#">Learn more</a></small>
    </div>
    <div class="section-body">
        <!-- Compensation Type -->
        <div class="mb-4">
            <h6>Compensation type</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="compensation_type" id="hourly_pay" value="hourly" 
                    {{ ($wage->compensation_type ?? 'hourly') === 'hourly' ? 'checked' : '' }}>
                <label class="form-check-label" for="hourly_pay">
                    Hourly pay
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="compensation_type" id="salary" value="salary"
                    {{ ($wage->compensation_type ?? 'hourly') === 'salary' ? 'checked' : '' }}>
                <label class="form-check-label" for="salary">
                    Salary
                </label>
            </div>
            
            <!-- Hourly Rate Field -->
            <div class="row mt-3" id="hourly_rate_field">
                <div class="col-md-6">
                    <label for="hourly_rate" class="form-label">Hourly Rate</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="hourly_rate" name="hourly_rate" 
                            value="{{ $wage->hourly_rate ?? 0.00 }}" step="0.01" min="0">
                    </div>
                </div>
            </div>

            <!-- Salary Fields (Hidden by default) -->
            <div class="row mt-3" id="salary_fields" style="display: none;">
                <div class="col-md-6">
                    <label for="salary_amount" class="form-label">Salary Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="salary_amount" name="salary_amount" 
                            value="{{ $wage->salary_amount ?? '' }}" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="salary_period" class="form-label">Period</label>
                    <select class="form-select" id="salary_period" name="salary_period">
                        <option value="monthly" {{ ($wage->salary_period ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="annually" {{ ($wage->salary_period ?? '') === 'annually' ? 'selected' : '' }}>Annually</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Overtime Settings -->
        <div class="mb-4">
            <h6>Overtime</h6>
            <p class="text-muted">Set how much this team member earns when working above their regular hours. <a href="#">Learn more</a></p>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="overtime_enabled" name="overtime_enabled" value="1"
                    {{ ($wage->overtime_enabled ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="overtime_enabled">
                    Overtime pay<br>
                    <small class="text-muted">Allow this team member to earn overtime</small>
                </label>
            </div>

            <div id="overtime_fields" style="display: {{ ($wage->overtime_enabled ?? false) ? 'block' : 'none' }};">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="regular_hours" class="form-label">Regular working hours</label>
                        <input type="number" class="form-control" id="regular_hours" name="regular_hours" 
                            value="{{ $wage->regular_hours ?? 40.0 }}" step="0.1" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="hours_type" class="form-label">Type</label>
                        <select class="form-select" id="hours_type" name="hours_type">
                            <option value="per_week" {{ ($wage->hours_type ?? 'per_week') === 'per_week' ? 'selected' : '' }}>Per week</option>
                            <option value="per_month" {{ ($wage->hours_type ?? 'per_week') === 'per_month' ? 'selected' : '' }}>Per month</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="overtime_type" class="form-label">Overtime type</label>
                        <select class="form-select" id="overtime_type" name="overtime_type">
                            <option value="hourly" {{ ($wage->overtime_type ?? 'hourly') === 'hourly' ? 'selected' : '' }}>Hourly</option>
                            <option value="fixed" {{ ($wage->overtime_type ?? 'hourly') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="overtime_rate" class="form-label">Overtime hourly rate</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="overtime_rate" name="overtime_rate" 
                                value="{{ $wage->overtime_rate ?? 0.00 }}" step="0.01" min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timesheet Settings -->
        <div class="mb-4">
            <h6>Timesheet settings</h6>
            <p class="text-muted">Configure timesheet settings for this team member. <a href="#">Learn more</a></p>
            
            <div class="mb-3">
                <h6>Proximity controls</h6>
                <label for="location_restrictions" class="form-label">Location restrictions</label>
                <select class="form-select" id="location_restrictions" name="location_restrictions">
                    <option value="workspace_default" {{ ($wage->location_restrictions ?? 'workspace_default') === 'workspace_default' ? 'selected' : '' }}>Workspace default (Disabled)</option>
                    <option value="enabled" {{ ($wage->location_restrictions ?? 'workspace_default') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                    <option value="disabled" {{ ($wage->location_restrictions ?? 'workspace_default') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
                <small class="text-muted">Prevent manual timesheet entries when more than 50m away</small>
            </div>

            <div class="mb-3">
                <label for="timesheet_automation" class="form-label">Timesheet automation</label>
                <select class="form-select" id="timesheet_automation" name="timesheet_automation">
                    <option value="workspace_default" {{ ($wage->timesheet_automation ?? 'workspace_default') === 'workspace_default' ? 'selected' : '' }}>Workspace default (Disabled)</option>
                    <option value="auto_clock_in" {{ ($wage->timesheet_automation ?? 'workspace_default') === 'auto_clock_in' ? 'selected' : '' }}>Auto clock in</option>
                    <option value="disabled" {{ ($wage->timesheet_automation ?? 'workspace_default') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
                <small class="text-muted">Automatically clock in at the beginning of shifts</small>
            </div>

            <div class="mb-3">
                <label for="automated_breaks" class="form-label">Automated breaks</label>
                <select class="form-select" id="automated_breaks" name="automated_breaks">
                    <option value="workspace_default" {{ ($wage->automated_breaks ?? 'workspace_default') === 'workspace_default' ? 'selected' : '' }}>Workspace default (disabled)</option>
                    <option value="enabled" {{ ($wage->automated_breaks ?? 'workspace_default') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                    <option value="disabled" {{ ($wage->automated_breaks ?? 'workspace_default') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
                <small class="text-muted">Automatically start and stop scheduled breaks</small>
            </div>

            <div class="mb-3">
                <label for="auto_check_out" class="form-label">Auto check out</label>
                <select class="form-select" id="auto_check_out" name="auto_check_out">
                    <option value="workspace_default" {{ ($wage->auto_check_out ?? 'workspace_default') === 'workspace_default' ? 'selected' : '' }}>Workspace default (disabled)</option>
                    <option value="enabled" {{ ($wage->auto_check_out ?? 'workspace_default') === 'enabled' ? 'selected' : '' }}>Enabled</option>
                    <option value="disabled" {{ ($wage->auto_check_out ?? 'workspace_default') === 'disabled' ? 'selected' : '' }}>Disabled</option>
                </select>
                <small class="text-muted">Automatically clock out at the end of shifts</small>
            </div>

            <small class="text-muted">Workspace default settings can be adjusted here</small>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end">
            <button type="button" id="saveWagesBtn" class="btn btn-primary">
                <i class="fas fa-spinner fa-spin d-none"></i>
                Save Wages Settings
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle compensation type fields
    function toggleCompensationFields() {
        const hourlyPay = document.getElementById('hourly_pay').checked;
        document.getElementById('hourly_rate_field').style.display = hourlyPay ? 'block' : 'none';
        document.getElementById('salary_fields').style.display = hourlyPay ? 'none' : 'block';
    }

    // Toggle overtime fields
    function toggleOvertimeFields() {
        const overtimeEnabled = document.getElementById('overtime_enabled').checked;
        document.getElementById('overtime_fields').style.display = overtimeEnabled ? 'block' : 'none';
    }

    // Event listeners
    document.getElementById('hourly_pay').addEventListener('change', toggleCompensationFields);
    document.getElementById('salary').addEventListener('change', toggleCompensationFields);
    document.getElementById('overtime_enabled').addEventListener('change', toggleOvertimeFields);

    // Initialize on page load
    toggleCompensationFields();
    toggleOvertimeFields();

    document.getElementById('saveWagesBtn').addEventListener('click', function() {
    const btn = this;
    const spinner = btn.querySelector('.fa-spinner');
    const originalText = btn.innerHTML;
    
    // Show loading state
    spinner.classList.remove('d-none');
    btn.disabled = true;
    btn.innerHTML = 'Saving...';

    // Collect form data
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    
    // Add all form fields
    const formFields = [
        'compensation_type', 'hourly_rate', 'salary_amount', 'salary_period',
        'overtime_enabled', 'regular_hours', 'hours_type', 'overtime_type',
        'overtime_rate', 'location_restrictions', 'timesheet_automation',
        'automated_breaks', 'auto_check_out'
    ];

    formFields.forEach(field => {
        const element = document.querySelector(`[name="${field}"]`);
        if (element) {
            if (element.type === 'checkbox') {
                formData.append(field, element.checked ? 1 : 0);
            } else if (element.type === 'radio') {
                const selected = document.querySelector(`[name="${field}"]:checked`);
                if (selected) formData.append(field, selected.value);
            } else {
                formData.append(field, element.value);
            }
        }
    });

    // Send AJAX request with proper headers
    fetch('{{ route("store.team-members.wages.store", $teamMember->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // If not JSON, it might be a redirect
            throw new Error('Server returned non-JSON response. Status: ' + response.status);
        }
    })
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message || 'An error occurred');
            if (data.errors) {
                console.error('Validation errors:', data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while saving: ' + error.message);
    })
    .finally(() => {
        // Restore button state
        spinner.classList.add('d-none');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin d-none"></i>Save Wages Settings';
    });
});

    function showAlert(type, message) {
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at the top of the form
        const cardBody = document.querySelector('.section-body');
        cardBody.insertBefore(alert, cardBody.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>