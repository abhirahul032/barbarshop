@extends('store.layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Calendar - {{ $date->format('F j, Y') }}</h5>
                    <div>
                        <div class="btn-group">
                            <a href="{{ route('store.appointments.calendar', ['date' => $date->copy()->subDay()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fa fa-chevron-left"></i> Previous
                            </a>
                            <a href="{{ route('store.appointments.calendar', ['date' => Carbon\Carbon::today()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-secondary">
                                Today
                            </a>
                            <a href="{{ route('store.appointments.calendar', ['date' => $date->copy()->addDay()->format('Y-m-d')]) }}" 
                               class="btn btn-outline-primary">
                                Next <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                        <a href="{{ route('store.appointments.create') }}" class="btn btn-primary ms-2">
                            <i class="fa fa-plus"></i> New Appointment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($teamMembers as $member)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fa fa-user me-2"></i>{{ $member->full_name }}
                                        </h6>
                                        <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $shift = $member->scheduledShifts->first();
                                        @endphp
                                        
                                        @if($shift)
                                            <div class="mb-3">
                                                <small class="text-muted">Shift:</small>
                                                <div class="fw-bold">
                                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('g:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($shift->end_time)->format('g:i A') }}
                                                </div>
                                                <small class="text-muted">{{ ucfirst($shift->shift_type) }}</small>
                                            </div>
                                        @else
                                            <div class="alert alert-warning py-2">
                                                <small>No shift scheduled</small>
                                            </div>
                                        @endif

                                        <div class="appointments-list">
                                            <small class="text-muted">Appointments:</small>
                                            @forelse($member->appointments as $appointment)
                                                <div class="appointment-item p-2 mb-2 rounded border 
                                                    {{ $appointment->status == 'scheduled' ? 'border-primary bg-light' : 
                                                       ($appointment->status == 'confirmed' ? 'border-success bg-light' : 
                                                       ($appointment->status == 'completed' ? 'border-secondary' : 
                                                       ($appointment->status == 'cancelled' ? 'border-danger bg-light' : 'border-warning bg-light'))) }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold small">{{ $appointment->client_name }}</div>
                                                            <div class="small">{{ $appointment->service->name }}</div>
                                                            <div class="text-muted smaller">
                                                                {{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }} - 
                                                                {{ \Carbon\Carbon::parse($appointment->end_time)->format('g:i A') }}
                                                            </div>
                                                        </div>
                                                        <span class="badge bg-{{ match($appointment->status) {
                                                            'scheduled' => 'primary',
                                                            'confirmed' => 'success',
                                                            'completed' => 'secondary',
                                                            'cancelled' => 'danger',
                                                            'no_show' => 'warning',
                                                        } }} ms-2">
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center text-muted py-3">
                                                    <small>No appointments</small>
                                                </div>
                                            @endforelse
                                        </div>

                                        @if($shift && $member->is_active && $member->allow_bookings)
                                            <div class="mt-3">
                                                <a href="{{ route('store.appointments.create', ['team_member_id' => $member->id, 'date' => $date->format('Y-m-d')]) }}" 
                                                   class="btn btn-sm btn-outline-primary w-100">
                                                    <i class="fa fa-plus"></i> Book Appointment
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($teamMembers->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa fa-users fa-3x text-muted mb-3"></i>
                            <h5>No team members found</h5>
                            <p class="text-muted">Add team members to start booking appointments.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.appointment-item {
    transition: all 0.2s ease;
}
.appointment-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.smaller {
    font-size: 0.75rem;
}
</style>
@endpush