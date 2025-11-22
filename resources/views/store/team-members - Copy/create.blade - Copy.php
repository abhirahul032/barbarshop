@extends('store.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Add team member</h1>
    <div>
        <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
        <button type="submit" form="teamMemberForm" class="btn btn-primary">Save Team Member</button>
    </div>
</div>

<form id="teamMemberForm" action="{{ route('store.team-members.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Left Sidebar Navigation -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal">
                            <strong>Personal</strong>
                            <div class="small text-muted">Profile, Addresses, Emergency contacts</div>
                        </a>
                        <a class="nav-link" data-bs-toggle="tab" href="#workspace">
                            <strong>Workspace</strong>
                            <div class="small text-muted">Services, Locations, Settings</div>
                        </a>
                        <a class="nav-link" data-bs-toggle="tab" href="#pay">
                            <strong>Pay</strong>
                            <div class="small text-muted">Wages and timesheets, Commissions, Pay runs</div>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Right Content Area -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Personal Tab -->
                <div class="tab-pane fade show active" id="personal">
                    @include('store.team-members.partials.personal-tab')
                </div>

                <!-- Workspace Tab -->
                <div class="tab-pane fade" id="workspace">
                    @include('store.team-members.partials.workspace-tab')
                </div>

                <!-- Pay Tab -->
                <div class="tab-pane fade" id="pay">
                    @include('store.team-members.partials.pay-tab')
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

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