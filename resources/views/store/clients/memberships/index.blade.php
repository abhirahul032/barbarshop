{{-- resources/views/store/clients/memberships/index.blade.php --}}

@extends('store.layouts.app')

@section('title', 'Client Memberships - ' . $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Memberships for {{ $client->first_name }} {{ $client->last_name }}
                    </h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMembershipModal">
                            <i class="fas fa-plus"></i> Add Membership
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($client->memberships->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Membership</th>
                                        <th>Type</th>
                                        <th>Sessions</th>
                                        <th>Validity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->memberships as $clientMembership)
                                        <tr>
                                            <td>
                                                <span class="badge" style="background-color: {{ $clientMembership->membership->color }}; color: white;">
                                                    {{ $clientMembership->membership->name }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($clientMembership->membership->session_type) }}</td>
                                            <td>
                                                @if($clientMembership->membership->session_type === 'limited')
                                                    {{ $clientMembership->sessions_used }} / {{ $clientMembership->membership->session_count }} used
                                                    ({{ $clientMembership->sessions_remaining }} remaining)
                                                @else
                                                    Unlimited
                                                @endif
                                            </td>
                                            <td>
                                                {{ $clientMembership->start_date->format('M j, Y') }} - 
                                                {{ $clientMembership->end_date->format('M j, Y') }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $clientMembership->status === 'active' ? 'success' : ($clientMembership->status === 'expired' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($clientMembership->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" 
                                                            data-target="#redeemModal{{ $clientMembership->id }}">
                                                        <i class="fas fa-ticket-alt"></i> Redeem
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" 
                                                            data-target="#editMembershipModal{{ $clientMembership->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('store.clients.memberships.destroy', [$client, $clientMembership]) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Are you sure you want to remove this membership?')">
                                                            <i class="fas fa-trash"></i> Remove
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Redeem Modal -->
                                                <div class="modal fade" id="redeemModal{{ $clientMembership->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Redeem Session</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('store.clients.memberships.redeem', [$client, $clientMembership]) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="service_id">Service *</label>
                                                                        <select name="service_id" id="service_id" class="form-control" required>
                                                                            <option value="">Select Service</option>
                                                                            @foreach($clientMembership->membership->services as $service)
                                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="appointment_id">Appointment (Optional)</label>
                                                                        <input type="number" name="appointment_id" id="appointment_id" 
                                                                               class="form-control" placeholder="Appointment ID">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Redeem Session</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editMembershipModal{{ $clientMembership->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Membership</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('store.clients.memberships.update', [$client, $clientMembership]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="sessions_used">Sessions Used</label>
                                                                        <input type="number" name="sessions_used" id="sessions_used" 
                                                                               class="form-control" value="{{ $clientMembership->sessions_used }}" 
                                                                               min="0" max="{{ $clientMembership->membership->session_count }}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select name="status" id="status" class="form-control">
                                                                            <option value="active" {{ $clientMembership->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                            <option value="expired" {{ $clientMembership->status === 'expired' ? 'selected' : '' }}>Expired</option>
                                                                            <option value="cancelled" {{ $clientMembership->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Membership</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Redemption History -->
                        <div class="mt-5">
                            <h5>Redemption History</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Membership</th>
                                            <th>Service</th>
                                            <th>Appointment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($client->memberships as $clientMembership)
                                            @foreach($clientMembership->redemptions as $redemption)
                                                <tr>
                                                    <td>{{ $redemption->redeemed_at->format('M j, Y g:i A') }}</td>
                                                    <td>{{ $clientMembership->membership->name }}</td>
                                                    <td>{{ $redemption->service->name }}</td>
                                                    <td>
                                                        @if($redemption->appointment_id)
                                                            #{{ $redemption->appointment_id }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>No memberships found for this client.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Membership Modal -->
<div class="modal fade" id="addMembershipModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Membership</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('store.clients.memberships.store', $client) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="membership_id">Membership *</label>
                        <select name="membership_id" id="membership_id" class="form-control" required>
                            <option value="">Select Membership</option>
                            @foreach($memberships as $membership)
                                <option value="{{ $membership->id }}" data-session-type="{{ $membership->session_type }}" data-session-count="{{ $membership->session_count }}">
                                    {{ $membership->name }} - ${{ $membership->price }} 
                                    ({{ $membership->session_description }} for {{ $membership->validity_description }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date *</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" 
                               value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="sessions_used">Initial Sessions Used (Optional)</label>
                        <input type="number" name="sessions_used" id="sessions_used" class="form-control" 
                               value="0" min="0">
                        <small class="form-text text-muted">
                            Set if the client has already used some sessions before adding the membership.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Membership</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const membershipSelect = document.getElementById('membership_id');
        const sessionsUsedInput = document.getElementById('sessions_used');
        
        membershipSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const sessionType = selectedOption.getAttribute('data-session-type');
            const sessionCount = selectedOption.getAttribute('data-session-count');
            
            if (sessionType === 'unlimited') {
                sessionsUsedInput.disabled = true;
                sessionsUsedInput.value = '0';
            } else {
                sessionsUsedInput.disabled = false;
                sessionsUsedInput.setAttribute('max', sessionCount);
            }
        });
    });
</script>
@endpush