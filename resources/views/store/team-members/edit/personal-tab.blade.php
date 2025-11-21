<form id="teamMemberForm" action="{{ route('store.team-members.update', $teamMember) }}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
<div style="margin-bottom: 20px;" class="d-flex justify-content-end">
    <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
    <button type="submit" form="teamMemberForm" class="btn btn-primary">Update Team Member</button>
</div>
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Profile</h5>
    </div>
    <div class="section-body">
        <style>
        .color-circle {
        transition: all 0.2s ease;
        position: relative;
    }
    .color-circle:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
    .color-option input:checked + label {
        border: 4px solid white !important;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.2);
    }
        .logo-preview {
        width: 120px;
        height: 120px;
        border: 2px dashed #cbd5e0;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .logo-preview:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .logo-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
        </style>
        
        <div class="mb-4">
                <label class="form-label">Profile Picture</label>
                
                
                <div class="d-flex align-items-start gap-3">
                    <div class="d-flex align-items-start gap-3">
                        @if(isset($teamMember) && $teamMember->profile_picture)
                            <div class="logo-preview current-logo">
                                <img src="{{ asset('storage/' . $teamMember->profile_picture) }}" alt="profile picture">
                            </div>
                        @endif
                    </div>

                    <div class="logo-preview-container text-center">
                        <input type="file" name="profile_picture" id="logoInput" class="d-none" accept="image/*" />
                        <label for="logoInput" class="logo-preview mx-auto">
                            <div class="logo-placeholder text-center">
                                <i class="fa fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <div class="small text-muted">
                                    {{ isset($teamMember) && $teamMember->profile_picture ? 'Change' : 'Click to upload' }} profile picture
                                </div>
                            </div>
                        </label>
                        <div class="form-text text-center mt-2">
                            Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                        </div>
                    </div>

                    @error('profile_picture')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
               
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
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       value="" placeholder="Leave blank to keep existing password">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                       value="" placeholder="Repeat password">
            </div>
            <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone number</label>
                <div class="input-group">
                    <select class="form-select flex-grow-0" style="width: auto;" name="phone_country_code" id="phone_country_code">
                        <option value="">Select Code</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->phone_code }}" 
                                {{ (old('phone_country_code', $teamMember->phone_country_code ?? '') == $country->phone_code) ? 'selected' : '' }}>
                                {{ $country->phone_code }} ({{ $country->iso_code }})
                            </option>
                        @endforeach
                    </select>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                           value="{{ old('phone_number', $teamMember->phone_number ?? '') }}">
                </div>
            </div>

            {{-- Row 3: Additional Phone (with country code dropdown), Country --}}
            <div class="col-md-6">
                <label for="additional_phone_number" class="form-label">Additional phone number</label>
                <div class="input-group">
                    <select class="form-select flex-grow-0" style="width: auto;" name="additional_phone_country_code" id="additional_phone_country_code">
                        <option value="">Select Code</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->phone_code }}" 
                                {{ (old('additional_phone_country_code', $teamMember->additional_phone_country_code ?? '') == $country->phone_code) ? 'selected' : '' }}>
                                {{ $country->phone_code }} ({{ $country->iso_code }})
                            </option>
                        @endforeach
                    </select>
                    <input type="tel" class="form-control" id="additional_phone_number" name="additional_phone_number" 
                           value="{{ old('additional_phone_number', $teamMember->additional_phone_number ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->name }}" 
                            {{ (old('country', $teamMember->country ?? '') == $country->name) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Row 4: Birthday (Date/Month & Year) --}}
            <div class="col-md-6">
                <label for="birthday" class="form-label">Birthday (Day and Month)</label>
                <input type="date" class="form-control" id="birthday" name="birthday" 
                        value="{{ old('birthday', isset($teamMember->birthday) ? \Carbon\Carbon::parse($teamMember->birthday)->format('Y-m-d') : '') }}"
                       placeholder="">
            </div>
           

            <div class="col-md-6">
                <label class="form-label">Calendar color</label>
                
                <div class="calendar-color-picker mt-2">
                    @php
                        $colors = [
                            '#3b82f6' => 'Blue',      // bg-blue-500
                            '#2563eb' => 'Dark Blue',
                            '#8b5cf6' => 'Purple',
                            '#a78bfa' => 'Light Purple',
                            '#c084fc' => 'Violet',
                            '#ec4899' => 'Pink',
                            '#f43f5e' => 'Rose',
                            '#fb923c' => 'Orange',
                            '#f97316' => 'Dark Orange',
                            '#fbbf24' => 'Yellow',
                            '#a3e635' => 'Lime',
                            '#84cc16' => 'Green',
                            '#22d3ee' => 'Cyan',
                            '#0ea5e9' => 'Sky Blue',
                        ];                        
                        $selected = old('calendar_color', $teamMember->calendar_color ?? '#3b82f6');
                    @endphp

                    <input type="hidden" name="calendar_color" id="calendar_color_hidden" value="{{ $selected }}">

                    <div class="d-flex flex-wrap gap-3">
                        @foreach($colors as $hex => $name)
                            <div class="color-option position-relative">
                                <input 
                                    type="radio" 
                                    name="calendar_color_radio" 
                                    id="color_{{ $loop->index }}" 
                                    value="{{ $hex }}"
                                    class="d-none"
                                    {{ $selected === $hex ? 'checked' : '' }}
                                >
                                <label 
                                    for="color_{{ $loop->index }}" 
                                    class="color-circle d-block rounded-circle cursor-pointer shadow-sm transition-all"
                                    style="background-color: {{ $hex }}; width: 44px; height: 44px; 
                                        border: {{ $selected === $hex ? '4px solid white' : '2px solid transparent' }};"
                                    title="{{ $name }}"
                                >
                                    @if($selected === $hex)
                                        <span class="position-absolute top-50 start-50 translate-middle rounded-circle bg-white" 
                                            style="width: 16px; height: 16px; box-shadow: 0 0 0 2px rgba(0,0,0,0.1);"></span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
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



<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Work details</h5>
        <small class="text-muted">Manage your team member's start date, and employment details</small>
    </div>
    <div class="section-body">
        <div class="row g-3">
            {{-- Row 1: Start Date (Day and Month & Year) --}}
            <div class="col-md-6">
                <label for="start_date" class="form-label">Start date </label>
                <input type="date" class="form-control" id="start_date" name="start_date" 
                        
                        value="{{ old('start_date', isset($teamMember->start_date) ? \Carbon\Carbon::parse($teamMember->start_date)->format('Y-m-d') : '') }}"
                       placeholder="start date">
            </div>            
            
            {{-- Row 2: End Date (Day and Month & Year) --}}
            <div class="col-md-6">
                <label for="end_date" class="form-label">End date </label>
                <input type="date" class="form-control" id="end_date" name="end_date" 
                      
                       value="{{ old('end_date', isset($teamMember->end_date) ? \Carbon\Carbon::parse($teamMember->end_date)->format('Y-m-d') : '') }}"
                       placeholder="End date">
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



<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Notes</h5>
    </div>
    <div class="section-body">
        <textarea class="form-control" id="notes" name="notes" rows="3" 
                  placeholder="Add a private note only viewable in the team member list">{{ old('notes', $teamMember->notes ?? '') }}</textarea>
    </div>
</div>
</form>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
       
       
        

        // Logo preview
        $('#logoInput').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.logo-preview').html(`<img src="${e.target.result}" alt="Personal image preview">`);
                }
                reader.readAsDataURL(file);
            }
        });

        
    });
</script>
<script>
    document.querySelectorAll('.color-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Update hidden input
            document.getElementById('calendar_color_hidden').value = this.value;

            // Update visual selection (remove all checks then add to current)
            document.querySelectorAll('.color-circle').forEach(circle => {
                circle.style.border = '2px solid transparent';
                circle.innerHTML = '';
            });

            if (this.checked) {
                const label = this.nextElementSibling;
                label.style.border = '4px solid white';
                label.style.boxShadow = '0 0 0 3px rgba(0,0,0,0.2)';

                // Add white inner dot
                const dot = document.createElement('span');
                dot.className = 'position-absolute top-50 start-50 translate-middle rounded-circle bg-white';
                dot.style.width = '16px';
                dot.style.height = '16px';
                dot.style.boxShadow = '0 0 0 2px rgba(0,0,0,0.1)';
                label.appendChild(dot);
            }
        });
    });
</script>
<script>
    // Make sure hidden calendar_color is updated BEFORE submit
    document.getElementById('teamMemberForm').addEventListener('submit', function(e) {
        const selected = document.querySelector('input[name="calendar_color_radio"]:checked');
        if (selected) {
            document.getElementById('calendar_color_hidden').value = selected.value;
        } else {
            // Fallback if none selected
            document.getElementById('calendar_color_hidden').value = '#3b82f6';
        }
    });

    // On page load: visually select the default/current color
    document.addEventListener('DOMContentLoaded', function () {
        const checked = document.querySelector('input[name="calendar_color_radio"]:checked') 
                     || document.querySelector('input[name="calendar_color_radio"]'); // fallback to first
        
        if (checked) {
            checked.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush