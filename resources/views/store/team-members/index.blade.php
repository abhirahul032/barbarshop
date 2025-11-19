@extends('store.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Team members</h1>
    <a href="{{ route('store.team-members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Team Member
    </a>
</div>

<!-- Trial Banner -->
<div class="alert alert-warning mb-4">
    <strong>Activate your plan</strong> to ensure uninterrupted access after your free trial ends in 14 days
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search team members">
                </div>
            </div>
            <div class="col-md-8 d-flex gap-2 justify-content-end">
                <select class="form-select" style="width: auto;">
                    <option>Filters</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
                <select class="form-select" style="width: auto;">
                    <option>Custom order</option>
                    <option>Name A-Z</option>
                    <option>Name Z-A</option>
                    <option>Recently Added</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Team Members List -->
<div class="card">
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($teamMembers as $member)
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="team-member-avatar">
                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-1 fw-bold">{{ $member->full_name }}</h5>
                        <p class="mb-1 text-muted small">{{ $member->email }}</p>
                        @if($member->phone_number)
                        <p class="mb-0 text-muted small">{{ $member->phone_number }}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted">
                            @if($member->review_count > 0)
                                ? {{ number_format($member->rating, 1) }} ({{ $member->review_count }} reviews)
                            @else
                                No reviews yet
                            @endif
                        </span>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="btn-group">
                            <a href="{{ route('store.team-members.show', $member) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('store.team-members.edit', $member) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>View calendar</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-clock me-2"></i>View scheduled shifts</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-umbrella-beach me-2"></i>Add time off</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('store.team-members.destroy', $member) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this team member?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if($teamMembers->isEmpty())
            <div class="list-group-item text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No team members found</h5>
                <p class="text-muted">Get started by adding your first team member</p>
                <a href="{{ route('store.team-members.create') }}" class="btn btn-primary">Add Team Member</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection