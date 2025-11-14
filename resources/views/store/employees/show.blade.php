@extends('store.layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Employee Details</h4>
                    <div>
                        <a href="{{ route('store.employees.edit', $employee) }}" class="btn btn-primary">Edit Employee</a>
                        <a href="{{ route('store.employees.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" class="img-fluid rounded-circle mb-3" width="200" height="200" style="object-fit: cover;" alt="{{ $employee->name }} photo">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                                    <i class="fas fa-user text-white" style="font-size: 80px;"></i>
                                </div>
                            @endif
                            <h3>{{ $employee->name }}</h3>
                            <span class="badge bg-{{ $employee->status == 'active' ? 'success' : ($employee->status == 'inactive' ? 'warning' : 'danger') }} fs-6">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Personal Information</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Email:</th>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address:</th>
                                            <td>{{ $employee->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth:</th>
                                            <td>{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age:</th>
                                            <td>{{ \Carbon\Carbon::parse($employee->date_of_birth)->age }} years</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5>Employment Details</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Employment Type:</th>
                                            <td>{{ ucfirst(str_replace('_', ' ', $employee->employment_type)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hire Date:</th>
                                            <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Working Hours:</th>
                                            <td>{{ \Carbon\Carbon::parse($employee->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($employee->end_time)->format('h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Salary Per Hour:</th>
                                            <td>${{ number_format($employee->salary_per_hour, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Working Days:</th>
                                            <td>
                                                @foreach($employee->working_days as $day)
                                                    <span class="badge bg-primary me-1">{{ ucfirst($day) }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h5>Emergency Contact</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Contact Name:</th>
                                            <td>{{ $employee->emergency_contact_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact Phone:</th>
                                            <td>{{ $employee->emergency_contact_phone }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5>Additional Information</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Specialization:</th>
                                            <td>{{ $employee->specialization ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Details:</th>
                                            <td>{{ $employee->bank_account_details ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($employee->services->count() > 0)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Services Provided</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Service Name</th>
                                                    <th>Price</th>
                                                    <th>Duration</th>
                                                    <th>Expertise Level</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($employee->services as $service)
                                                <tr>
                                                    <td>{{ $service->name }}</td>
                                                    <td>${{ number_format($service->price, 2) }}</td>
                                                    <td>{{ $service->duration_minutes }} minutes</td>
                                                    <td>
                                                        @php
                                                            $expertiseLevel = $service->pivot->expertise_level ?? 1;
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                                                <div class="progress-bar" role="progressbar" style="width: {{ ($expertiseLevel / 5) * 100 }}%"></div>
                                                            </div>
                                                            <span>{{ $expertiseLevel }}/5</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection