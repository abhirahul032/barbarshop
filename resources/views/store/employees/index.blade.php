@extends('store.layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Employees</h4>
                    <a href="{{ route('store.employees.create') }}" class="btn btn-primary">Add Employee</a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('store.employees.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Search store.employees..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('store.employees.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Employees Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('store.employees.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
                                            Name
                                            @if(request('sort') == 'name')
                                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>Contact</th>
                                    <th>Working Days</th>
                                    <th>Hours</th>
                                    <th>Salary/Hour</th>
                                    <th>Services</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($employee->photo)                                               

                                            <img src="{{ asset('storage/' . $employee->photo) }}" width="50" height="50" style="object-fit: cover;" alt="{{ $employee->name }} logo">

                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $employee->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $employee->employment_type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $employee->email }}</div>
                                        <small class="text-muted">{{ $employee->phone }}</small>
                                    </td>
                                    <td>
                                        @foreach($employee->working_days as $day)
                                            <span class="badge bg-primary">{{ ucfirst($day) }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($employee->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($employee->end_time)->format('h:i A') }}</td>
                                    <td>${{ number_format($employee->salary_per_hour, 2) }}</td>
                                    <td>
                                        @foreach($employee->services->take(3) as $service)
                                            <span class="badge bg-info">{{ $service->name }}</span>
                                        @endforeach
                                        @if($employee->services->count() > 3)
                                            <span class="badge bg-secondary">+{{ $employee->services->count() - 3 }} more</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $employee->status == 'active' ? 'success' : ($employee->status == 'inactive' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($employee->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('store.employees.show', $employee) }}" ><i class="ri-eye-fill align-bottom me-2 text-muted"></i></a>
                                            <a href="{{ route('store.employees.edit', $employee) }}" ><i class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                            <form action="{{ route('store.employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"  style="border:0px;" class="" onclick="return confirm('Are you sure?')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
                        </div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection