@extends('store.layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Appointment Details - {{ $appointment->appointment_number }}</h5>
                    <div class="btn-group">
                        <a href="{{ route('store.appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('store.appointments.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Client Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $appointment->client_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $appointment->client_email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $appointment->client_phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Client Notes:</strong></td>
                                    <td>{{ $appointment->client_notes ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6>Appointment Details</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Service:</strong></td>
                                    <td>{{ $appointment->service->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Team Member:</strong></td>
                                    <td>{{ $appointment->teamMember->full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $appointment->appointment_date->format('M j, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Time:</strong></td>
                                    <td>{{ $appointment->formatted_start_time }} - {{ $appointment->formatted_end_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>{{ $appointment->duration }} minutes</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Financial Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>${{ number_format($appointment->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Commission:</strong></td>
                                    <td>${{ number_format($appointment->commission_amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6>Status & Notes</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Status:</strong></td>
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
                                </tr>
                                <tr>
                                    <td><strong>Internal Notes:</strong></td>
                                    <td>{{ $appointment->notes ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($appointment->status === 'scheduled')
                            <form action="{{ route('store.appointments.update', $appointment) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Confirm Appointment
                                </button>
                            </form>
                        @endif

                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                            <form action="{{ route('store.appointments.update', $appointment) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-flag-checkered"></i> Mark as Completed
                                </button>
                            </form>

                            <form action="{{ route('store.appointments.update', $appointment) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    <i class="fa fa-times"></i> Cancel Appointment
                                </button>
                            </form>
                        @endif

                        @if($appointment->status === 'scheduled')
                            <form action="{{ route('store.appointments.update', $appointment) }}" method="POST" class="d-grid">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="no_show">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Mark as no show?')">
                                    <i class="fa fa-user-times"></i> Mark as No Show
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('store.appointments.destroy', $appointment) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">
                                <i class="fa fa-trash"></i> Delete Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Team Member Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if($appointment->teamMember->profile_picture)
                            <img src="{{ asset('storage/' . $appointment->teamMember->profile_picture) }}" 
                                 alt="{{ $appointment->teamMember->full_name }}" 
                                 class="rounded-circle mb-2" width="80" height="80">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" 
                                 style="width: 80px; height: 80px;">
                                <i class="fa fa-user text-white fa-2x"></i>
                            </div>
                        @endif
                        <h6>{{ $appointment->teamMember->full_name }}</h6>
                        <p class="text-muted small mb-1">{{ $appointment->teamMember->job_title }}</p>
                        <p class="text-muted small">{{ $appointment->teamMember->email }}</p>
                        
                        @if($appointment->teamMember->phone_number)
                            <p class="small">
                                <i class="fa fa-phone me-1"></i>
                                {{ $appointment->teamMember->phone_number }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection