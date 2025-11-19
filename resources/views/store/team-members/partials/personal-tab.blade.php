<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Profile</h5>
    </div>
    <div class="section-body">
        
        {{-- Profile Picture/Image Field --}}
        <div class="mb-4">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <div class="d-flex align-items-center">
                {{-- Placeholder for current image or avatar --}}
                <div class="me-3" style="width: 80px; height: 80px; border: 1px solid #ccc; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    @if(isset($teamMember->profile_picture) && $teamMember->profile_picture)
                        <img src="{{ asset($teamMember->profile_picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </div>
                {{-- File Input --}}
                <input class="form-control" type="file" id="profile_picture" name="profile_picture" accept="image/*">
            </div>
            @if(isset($teamMember->profile_picture) && $teamMember->profile_picture)
                <small class="text-muted mt-1 d-block">Upload a new image to replace the current one.</small>
            @endif
        </div>
        
        <div class="row g-3">
            {{-- Row 1: First Name, Last Name --}}
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
            
            {{-- Row 2: Email, Phone Number (with code dropdown) --}}
            <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email', $teamMember->email ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone number</label>
                <div class="input-group">
                    <select class="form-select flex-grow-0" style="width: auto;" name="phone_country_code" id="phone_country_code">
                        <option value="+91" {{ (old('phone_country_code', $teamMember->phone_country_code ?? '+91') == '+91') ? 'selected' : '' }}>+91</option>
                        <option value="+1" {{ (old('phone_country_code', $teamMember->phone_country_code ?? '+91') == '+1') ? 'selected' : '' }}>+1</option>
                        <option value="+44" {{ (old('phone_country_code', $teamMember->phone_country_code ?? '+91') == '+44') ? 'selected' : '' }}>+44</option>
                        {{-- Add more country codes as needed --}}
                    </select>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                           value="{{ old('phone_number', $teamMember->phone_number ?? '') }}">
                </div>
            </div>

            {{-- Row 3: Additional Phone (with code dropdown), Country --}}
            <div class="col-md-6">
                <label for="additional_phone_number" class="form-label">Additional phone number</label>
                <div class="input-group">
                    <select class="form-select flex-grow-0" style="width: auto;" name="additional_phone_country_code" id="additional_phone_country_code">
                        <option value="+91" {{ (old('additional_phone_country_code', $teamMember->additional_phone_country_code ?? '+91') == '+91') ? 'selected' : '' }}>+91</option>
                        <option value="+1" {{ (old('additional_phone_country_code', $teamMember->additional_phone_country_code ?? '+91') == '+1') ? 'selected' : '' }}>+1</option>
                        <option value="+44" {{ (old('additional_phone_country_code', $teamMember->additional_phone_country_code ?? '+91') == '+44') ? 'selected' : '' }}>+44</option>
                        {{-- Add more country codes as needed --}}
                    </select>
                    <input type="tel" class="form-control" id="additional_phone_number" name="additional_phone_number" 
                           value="{{ old('additional_phone_number', $teamMember->additional_phone_number ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select country</option>
                    <option value="India" {{ (old('country', $teamMember->country ?? '') == 'India') ? 'selected' : '' }}>India</option>
                    <option value="USA" {{ (old('country', $teamMember->country ?? '') == 'USA') ? 'selected' : '' }}>USA</option>
                    </select>
            </div>

            {{-- Row 4: Birthday (Date/Month & Year) --}}
            <div class="col-md-6">
                <label for="birthday_date_month" class="form-label">Birthday (Day and Month)</label>
                <input type="text" class="form-control" id="birthday_date_month" name="birthday_date_month" 
                       value="{{ old('birthday_date_month', $teamMember->birthday_date_month ?? '') }}" 
                       placeholder="Day and month">
            </div>
            <div class="col-md-6">
                <label for="birthday_year" class="form-label">Birthday (Year)</label>
                <input type="number" class="form-control" id="birthday_year" name="birthday_year" 
                       value="{{ old('birthday_year', $teamMember->birthday_year ?? '') }}" 
                       placeholder="Year" min="1900" max="{{ date('Y') }}">
            </div>

            {{-- Row 5: Calendar Color, Job Title --}}
            <div class="col-md-6">
                <label for="calendar_color" class="form-label">Calendar color</label>
                <select class="form-select" id="calendar_color" name="calendar_color">
                    <option value="">Select a color</option>
                    {{-- Color options --}}
                    @php
                        $colors = [
                            '#007bff' => 'Blue', '#28a745' => 'Green', '#ffc107' => 'Yellow', '#dc3545' => 'Red',
                            '#6f42c1' => 'Purple', '#fd7e14' => 'Orange', '#6c757d' => 'Gray' 
                        ];
                        $selected_color = old('calendar_color', $teamMember->calendar_color ?? '');
                    @endphp
                    @foreach ($colors as $hex => $name)
                        <option value="{{ $hex }}" {{ ($selected_color == $hex) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="job_title" class="form-label">Job title</label>
                <input type="text" class="form-control" id="job_title" name="job_title" 
                       value="{{ old('job_title', $teamMember->job_title ?? '') }}">
            </div>
            
            {{-- Row 6: Visible to clients checkbox --}}
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

---

<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Work details</h5>
        <small class="text-muted">Manage your team member's start date, and employment details</small>
    </div>
    <div class="section-body">
        <div class="row g-3">
            {{-- Row 1: Start Date (Day and Month & Year) --}}
            <div class="col-md-3">
                <label for="start_date_month" class="form-label">Start date (Day and Month)</label>
                <input type="text" class="form-control" id="start_date_month" name="start_date_month" 
                       value="{{ old('start_date_month', $teamMember->start_date_month ?? '') }}"
                       placeholder="Day and month">
            </div>
            <div class="col-md-3">
                <label for="start_year" class="form-label">Start date (Year)</label>
                <input type="number" class="form-control" id="start_year" name="start_year" 
                       value="{{ old('start_year', $teamMember->start_year ?? '') }}"
                       placeholder="Year" min="1900" max="{{ date('Y') }}">
            </div>
            
            {{-- Row 2: End Date (Day and Month & Year) --}}
            <div class="col-md-3">
                <label for="end_date_month" class="form-label">End date (Day and Month)</label>
                <input type="text" class="form-control" id="end_date_month" name="end_date_month" 
                       value="{{ old('end_date_month', $teamMember->end_date_month ?? '') }}"
                       placeholder="Day and month">
            </div>
            <div class="col-md-3">
                <label for="end_year" class="form-label">End date (Year)</label>
                <input type="number" class="form-control" id="end_year" name="end_year" 
                       value="{{ old('end_year', $teamMember->end_year ?? '') }}"
                       placeholder="Year" min="1900" max="{{ date('Y') }}">
            </div>

            {{-- Row 3: Employment Type, Team Member ID --}}
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

---

<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Notes</h5>
    </div>
    <div class="section-body">
        <textarea class="form-control" id="notes" name="notes" rows="3" 
                  placeholder="Add a private note only viewable in the team member list">{{ old('notes', $teamMember->notes ?? '') }}</textarea>
    </div>
</div>