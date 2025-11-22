@extends('store.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">{{ $teamMember->full_name }}</h1>
    <div>
        <a href="{{ route('store.team-members.edit', $teamMember) }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <!-- Left Sidebar -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="team-member-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 24px;">
                    {{ substr($teamMember->first_name, 0, 1) }}{{ substr($teamMember->last_name, 0, 1) }}
                </div>
                <h5 class="mb-1">{{ $teamMember->full_name }}</h5>
                <p class="text-muted mb-3">{{ $teamMember->job_title ?? 'No job title' }}</p>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm">View Calendar</button>
                    <button class="btn btn-outline-primary btn-sm">View Scheduled Shifts</button>
                    <button class="btn btn-outline-primary btn-sm">Add Time Off</button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link active" href="#overview" data-bs-toggle="tab">
                        <i class="fas fa-chart-bar me-2"></i>Overview
                    </a>
                    <a class="nav-link" href="#personal-info" data-bs-toggle="tab">
                        <i class="fas fa-user me-2"></i>Personal
                    </a>
                    <a class="nav-link" href="#workspace-info" data-bs-toggle="tab">
                        <i class="fas fa-briefcase me-2"></i>Workspace
                    </a>
                    <a class="nav-link" href="#pay-info" data-bs-toggle="tab">
                        <i class="fas fa-money-bill me-2"></i>Pay
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Right Content -->
    <div class="col-md-9">
        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview">
                @include('store.team-members.partials.overview-tab')
            </div>

            <!-- Personal Info Tab -->
            <div class="tab-pane fade" id="personal-info">
                @include('store.team-members.partials.personal-show-tab')
            </div>

            <!-- Workspace Info Tab -->
            <div class="tab-pane fade" id="workspace-info">
                @include('store.team-members.partials.workspace-show-tab')
            </div>

            <!-- Pay Info Tab -->
            <div class="tab-pane fade" id="pay-info">
                @include('store.team-members.partials.pay-show-tab')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endpush