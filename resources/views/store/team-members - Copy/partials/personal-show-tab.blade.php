<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Personal Information</h5>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Full name</strong><br>
                {{ $teamMember->full_name }}
            </div>
            <div class="col-md-6">
                <strong>Phone number</strong><br>
                {{ $teamMember->phone_number ?? 'Not provided' }}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Country</strong><br>
                {{ $teamMember->country ?? 'Not provided' }}
            </div>
            <div class="col-md-6">
                <strong>Job title</strong><br>
                {{ $teamMember->job_title ?? 'Not provided' }}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Work details</strong><br>
                Employment: {{ $teamMember->start_date ? $teamMember->start_date->format('F jS, Y') : 'Not set' }} - 
                {{ $teamMember->end_date ? $teamMember->end_date->format('F jS, Y') : 'present' }}
            </div>
            <div class="col-md-6">
                <strong>Team member ID</strong><br>
                {{ $teamMember->team_member_id ?? 'Not set' }}
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Email</strong><br>
                {{ $teamMember->email }}
            </div>
            <div class="col-md-6">
                <strong>Date of birth</strong><br>
                {{ $teamMember->birthday ? $teamMember->birthday->format('F jS') : 'Not set' }}
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <strong>Calendar color</strong><br>
                <span class="badge" style="background-color: {{ $teamMember->calendar_color }}; color: white;">
                    {{ $teamMember->calendar_color }}
                </span>
            </div>
        </div>
    </div>
</div>