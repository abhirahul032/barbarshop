@extends('admin.layouts.app')

@section('title','Create Store')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Create Store</h4>
    <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Display Validation Errors -->
@include('admin.layouts.error')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.store.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" 
                               accept="image/*" />
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">URL *</label>
                        <input name="url" type="url" class="form-control @error('url') is-invalid @enderror" 
                               value="{{ old('url') }}" required placeholder="https://example.com" />
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               required minlength="6" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum 6 characters</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No of employees *</label>
                        <input name="no_of_employees" type="number" class="form-control @error('no_of_employees') is-invalid @enderror" 
                               value="{{ old('no_of_employees') }}" required min="1" />
                        @error('no_of_employees')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Billing Period *</label>
                        <select name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" required>
                            <option value="">Select Billing Period</option>
                            <option value="monthly" {{ old('billing_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                        @error('billing_period')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Start Date *</label>
                        <input name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" 
                               value="{{ old('start_date') }}" required />
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">End Date *</label>
                        <input name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date') }}" required />
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Package *</label>
                <select name="package_id" class="form-control @error('package_id') is-invalid @enderror" required>
                    <option value="">Select Package</option>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}" {{ old('package_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} - ${{ number_format($p->price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('package_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Business Types *</label>
                <select name="business_types[]" class="form-control @error('business_types') is-invalid @enderror" multiple required>
                    @foreach($businessTypes as $businessType)
                        <option value="{{ $businessType->id }}" {{ in_array($businessType->id, old('business_types', [])) ? 'selected' : '' }}>
                            {{ $businessType->name }}
                        </option>
                    @endforeach
                </select>
                @error('business_types')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Hold Ctrl/Cmd to select multiple business types</div>
            </div>

            <button class="btn btn-dark">Save Store</button>
            <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection