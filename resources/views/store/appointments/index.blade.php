@extends('store.layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointments</h5>
                    <div>
                        <a href="{{ route('store.appointments.calendar') }}" class="btn btn-secondary">
                            <i class="fa fa-calendar"></i> Calendar View
                        </a>
                        <a href="{{ route('store.appointments.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> New Appointment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" class="row mb-4">
                        <div class="col-md-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" 
                                   value="{{ request('date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="team_member_id" class="form-label">Team Member</label>
                            <select name="team_member_id" id="team_member_id" class="form-select">
                                <option value="">All Team Members</option>
                                @foreach($teamMembers as $member)
                                    <option value="{{ $member->id }}" {{ request('team_member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('store.appointments.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Appointment #</th>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Team Member</th>
                                    <th>Date & Time</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_number }}</td>
                                        <td>
                                            <div>{{ $appointment->client_name }}</div>
                                            <small class="text-muted">{{ $appointment->client_email }}</small>
                                        </td>
                                        <td>{{ $appointment->service->name }}</td>
                                        <td>{{ $appointment->teamMember->full_name }}</td>
                                        <td>
                                            <div>{{ $appointment->appointment_date->format('M j, Y') }}</div>
                                            <small class="text-muted">{{ $appointment->formatted_start_time }} - {{ $appointment->formatted_end_time }}</small>
                                        </td>
                                        <td>{{ $appointment->duration }} min</td>
                                        <td>${{ number_format($appointment->price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ match($appointment->status) {
                                                'scheduled' => 'primary',
                                                'confirmed' => 'success',
                                                'completed' => 'secondary',
                                                'cancelled' => 'danger',
                                                'no_show' => 'warning',
                                            } }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('store.appointments.show', $appointment) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('store.appointments.edit', $appointment) }}" 
                                                   class="btn btn-sm btn-outline-secondary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('store.appointments.destroy', $appointment) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No appointments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection