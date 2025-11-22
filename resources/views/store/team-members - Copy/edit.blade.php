@extends('store.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Edit team member</h1>
   
</div>


    <div class="row">
        <div class="col-md-3 col-lg-2 border-end bg-white p-0">
            <div class="list-group list-group-flush">
               
                @include('store.team-members.team_sidebar', [
                    'action' => 'edit',                   
                ])
                

            </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
             @include('store.layouts.error')
            <div class="tab-content">

                <!-- Personal Tab -->
                <div class="tab-pane fade show active" id="personal_tab">
                    @include('store.team-members.edit.personal-tab')
                </div>

                <!-- Address Tab -->
                <div class="tab-pane fade" id="address_tab">
                    @include('store.team-members.edit.address')
                </div>

                <!-- Emergency Tab -->
                <div class="tab-pane fade" id="emergency_tab">
                    @include('store.team-members.edit.emergency')
                </div>

                <!-- Workspace Tabs -->
                <div class="tab-pane fade" id="services_tab">
                    @include('store.team-members.edit.workspace-tab')
                </div>

                <div class="tab-pane fade" id="locations_tab">
                    @include('store.team-members.edit.location')
                </div>

                <div class="tab-pane fade" id="settings_tab">
                    @include('store.team-members.edit.setting')
                </div>

                <!-- Pay Tabs -->
                <div class="tab-pane fade" id="wages_tab">                   
                    @include('store.team-members.edit.wages', [
                        'teamMember' => $teamMember,
                        'wage' => $teamMember->wage
                    ])
                </div>

                <div class="tab-pane fade" id="commission_tab">                    
                    
                    @include('store.team-members.edit.commission', [
                        'teamMember' => $teamMember,
                        'commission' => $teamMember->commission,
                        'services' => $services // Pass services if you have them
                    ])
                </div>

                <div class="tab-pane fade" id="payrun_tab">                    
                    @include('store.team-members.edit.payrun', [
                        'teamMember' => $teamMember,
                        'payRun' => $teamMember->payRun
                    ])
                </div>

            </div>

        </div>
    </div>

@endsection

@push('styles')
<style>
    .nav-pills .nav-link {
        border-radius: 0;
        padding: 1rem 1.25rem;
        border-left: 3px solid transparent;
        color: #495057;
        transition: all 0.2s;
    }
    
    .nav-pills .nav-link:hover {
        background-color: #f8f9fa;
    }
    
    .nav-pills .nav-link.active {
        background-color: #f8f9fa;
        color: #0d6efd;
        border-left-color: #0d6efd;
        font-weight: 600;
    }
    
    .nav-pills .nav-link .fw-bold {
        font-size: 1rem;
    }
    
    .nav-pills .nav-link small {
        font-size: 0.8rem;
        line-height: 1.2;
    }
    
    .section-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
    }
    
    .section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }
    
    .section-body {
        padding: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Tab navigation
    document.addEventListener('DOMContentLoaded', function() {
        // Activate tab on sidebar click
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Form submission
        document.getElementById('teamMemberForm').addEventListener('submit', function(e) {
            // Add validation here if needed
            console.log('Form submitted');
        });
    });
</script>
@endpush