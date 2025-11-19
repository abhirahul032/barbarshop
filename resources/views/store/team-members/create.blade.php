@extends('store.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Add team member</h1>
    
</div>
<style>
    .tab-content .card{padding: 20px;} 
</style>
<form id="teamMemberForm" action="{{ route('store.team-members.store') }}" method="POST">
    @csrf
    <div>
        <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
        <button type="submit" form="teamMemberForm" class="btn btn-primary">Save Team Member</button>
    </div>
    <div class="row">
        
        <!-- Left Sidebar Navigation -->
        <!-- LEFT SIDEBAR -->
        <div class="col-md-3 col-lg-2 border-end bg-white p-0">
            <div class="list-group list-group-flush">

                <div class="p-3 fw-bold text-uppercase small text-muted">
                    Personal
                </div>

                <a href="#" class="list-group-item list-group-item-action active" data-bs-toggle="tab" data-bs-target="#personal_tab">
                    Profile
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#address_tab">
                    Addresses
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#emergency_tab">
                    Emergency contacts
                </a>

                <div class="p-3 fw-bold text-uppercase small text-muted">
                    Workspace
                </div>

                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#services_tab">
                    Services
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#locations_tab">
                    Locations
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#settings_tab">
                    Settings
                </a>

                <div class="p-3 fw-bold text-uppercase small text-muted">
                    Pay
                </div>

                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#wages_tab">
                    Wages and timesheets
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#commission_tab">
                    Commissions
                </a>
                <a href="#" class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#payrun_tab">
                    Pay runs
                </a>

            </div>
        </div>
 <div class="col-md-9 col-lg-10 p-4">

            <div class="tab-content">

                <!-- Personal Tab -->
                <div class="tab-pane fade show active" id="personal_tab">
                    @include('store.team-members.partials.personal-tab')
                </div>

                <!-- Address Tab -->
                <div class="tab-pane fade" id="address_tab">
                    @include('store.team-members.partials.address')
                </div>

                <!-- Emergency Tab -->
                <div class="tab-pane fade" id="emergency_tab">
                    @include('store.team-members.partials.emergency')
                </div>

                <!-- Workspace Tabs -->
                <div class="tab-pane fade" id="services_tab">
                    @include('store.team-members.partials.workspace-tab')
                </div>

                <div class="tab-pane fade" id="locations_tab">
                    @include('store.team-members.partials.location')
                </div>

                <div class="tab-pane fade" id="settings_tab">
                    @include('store.team-members.partials.setting')
                </div>

                <!-- Pay Tabs -->
                <div class="tab-pane fade" id="wages_tab">
                    @include('store.team-members.partials.wages')
                </div>

                <div class="tab-pane fade" id="commission_tab">                    
                    @include('store.team-members.partials.commission')
                </div>

                <div class="tab-pane fade" id="payrun_tab">
                    @include('store.team-members.partials.payrun')
                </div>

            </div>

        </div>
        <!-- Right Content Area -->
        <div class="col-md-9" style="display: none">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Personal Tab -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="v-pills-personal-tab">
                    @include('store.team-members.partials.personal-tab')
                </div>

                <!-- Workspace Tab -->
                <div class="tab-pane fade" id="workspace" role="tabpanel" aria-labelledby="v-pills-workspace-tab">
                    @include('store.team-members.partials.workspace-tab')
                </div>

                <!-- Pay Tab -->
                <div class="tab-pane fade" id="pay" role="tabpanel" aria-labelledby="v-pills-pay-tab">
                    @include('store.team-members.partials.pay-tab')
                </div>
            </div>
        </div>
    </div>
</form>
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