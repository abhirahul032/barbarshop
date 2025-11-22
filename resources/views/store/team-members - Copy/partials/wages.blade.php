<!-- Wages and Timesheets Section -->
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
                <input class="form-check-input" type="radio" name="compensation_type" id="hourly_pay" value="hourly" checked>
                <label class="form-check-label" for="hourly_pay">
                    Hourly pay
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="compensation_type" id="salary" value="salary">
                <label class="form-check-label" for="salary">
                    Salary
                </label>
            </div>
        </div>

        <!-- Overtime Settings -->
        <div class="mb-4">
            <h6>Overtime</h6>
            <p class="text-muted">Set how much this team member earns when working above their regular hours. <a href="#">Learn more</a></p>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="overtime_pay" name="overtime_pay" value="1">
                <label class="form-check-label" for="overtime_pay">
                    Overtime pay<br>
                    <small class="text-muted">Allow this team member to earn overtime</small>
                </label>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="regular_hours" class="form-label">Regular working hours</label>
                    <input type="number" class="form-control" id="regular_hours" name="regular_hours" value="40.0" step="0.1">
                </div>
                <div class="col-md-6">
                    <label for="hours_type" class="form-label">Type</label>
                    <select class="form-select" id="hours_type" name="hours_type">
                        <option value="per_week">Per week</option>
                        <option value="per_month">Per month</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="overtime_type" class="form-label">Overtime type</label>
                    <select class="form-select" id="overtime_type" name="overtime_type">
                        <option value="hourly">Hourly</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="overtime_rate" class="form-label">Overtime hourly rate</label>
                    <div class="input-group">
                        <span class="input-group-text">?</span>
                        <input type="number" class="form-control" id="overtime_rate" name="overtime_rate" value="0.00" step="0.01">
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
                    <option value="workspace_default">Workspace default (Disabled)</option>
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
                <small class="text-muted">Prevent manual timesheet entries when more than 50m away</small>
            </div>

            <div class="mb-3">
                <label for="timesheet_automation" class="form-label">Timesheet automation</label>
                <select class="form-select" id="timesheet_automation" name="timesheet_automation">
                    <option value="workspace_default">Workspace default (Disabled)</option>
                    <option value="auto_clock_in">Auto clock in</option>
                    <option value="disabled">Disabled</option>
                </select>
                <small class="text-muted">Automatically clock in at the beginning of shifts</small>
            </div>

            <div class="mb-3">
                <label for="automated_breaks" class="form-label">Automated breaks</label>
                <select class="form-select" id="automated_breaks" name="automated_breaks">
                    <option value="workspace_default">Workspace default (disabled)</option>
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
                <small class="text-muted">Automatically start and stop scheduled breaks</small>
            </div>

            <small class="text-muted">Workspace default settings can be adjusted here</small>
        </div>
    </div>
</div>