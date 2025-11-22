<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Profile</h5>
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">First name *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" 
                       value="{{ old('first_name', $teamMember->first_name ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Last name *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" 
                       value="{{ old('last_name', $teamMember->last_name ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email', $teamMember->email ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone number</label>
                <div class="input-group">
                    <span class="input-group-text">+91</span>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                           value="{{ old('phone_number', $teamMember->phone_number ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="additional_phone_number" class="form-label">Additional phone number</label>
                <div class="input-group">
                    <span class="input-group-text">+91</span>
                    <input type="tel" class="form-control" id="additional_phone_number" name="additional_phone_number" 
                           value="{{ old('additional_phone_number', $teamMember->additional_phone_number ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" 
                       value="{{ old('birthday', $teamMember->birthday ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select country</option>
                    <option value="India" {{ (old('country', $teamMember->country ?? '') == 'India') ? 'selected' : '' }}>India</option>
                    <option value="USA" {{ (old('country', $teamMember->country ?? '') == 'USA') ? 'selected' : '' }}>USA</option>
                    <!-- Add more countries -->
                </select>
            </div>
            <div class="col-md-6">
                <label for="job_title" class="form-label">Job title</label>
                <input type="text" class="form-control" id="job_title" name="job_title" 
                       value="{{ old('job_title', $teamMember->job_title ?? '') }}">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="visible_to_clients" name="visible_to_clients" value="1" 
                           {{ old('visible_to_clients', $teamMember->visible_to_clients ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="visible_to_clients">
                        Visible to clients
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Work Details Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Work details</h5>
        <small class="text-muted">Manage your team member's start date, and employment details</small>
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Start date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" 
                       value="{{ old('start_date', $teamMember->start_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="end_date" class="form-label">End date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" 
                       value="{{ old('end_date', $teamMember->end_date ?? '') }}">
            </div>
            <div class="col-md-6">
                <label for="employment_type" class="form-label">Employment type</label>
                <select class="form-select" id="employment_type" name="employment_type">
                    <option value="">Select an option</option>
                    <option value="full_time" {{ (old('employment_type', $teamMember->employment_type ?? '') == 'full_time') ? 'selected' : '' }}>Full Time</option>
                    <option value="part_time" {{ (old('employment_type', $teamMember->employment_type ?? '') == 'part_time') ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ (old('employment_type', $teamMember->employment_type ?? '') == 'contract') ? 'selected' : '' }}>Contract</option>
                    <option value="temporary" {{ (old('employment_type', $teamMember->employment_type ?? '') == 'temporary') ? 'selected' : '' }}>Temporary</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="team_member_id" class="form-label">Team member ID</label>
                <input type="text" class="form-control" id="team_member_id" name="team_member_id" 
                       value="{{ old('team_member_id', $teamMember->team_member_id ?? '') }}">
                <small class="text-muted">An identifier used for external systems like payroll</small>
            </div>
        </div>
    </div>
</div>

<!-- Notes Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Notes</h5>
    </div>
    <div class="section-body">
        <textarea class="form-control" id="notes" name="notes" rows="3" 
                  placeholder="Add a private note only viewable in the team member list">{{ old('notes', $teamMember->notes ?? '') }}</textarea>
    </div>
</div>



