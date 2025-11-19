@extends('admin.layouts.app')

@section('title','Edit Store')


   
@push('js')    
<script src="{{ asset('assets/libs/multi.js/multi.min.js') }}"></script>   
<script src="{{ asset('assets/libs/%40tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>   
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>   
<script src="{{ asset('assets/js/pages/form-input-spin.init.js') }}"></script>   
<script src="{{ asset('assets/js/pages/flag-input.init.js') }}"></script>
@endpush

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Edit Store</h4>
    <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@include('admin.layouts.error')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.store.update', $store->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $store->name) }}" required />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Logo</label><br>
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" width="60" class="mb-2"><br>
                        @endif
                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" 
                               accept="image/*" />
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to keep current logo</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">URL *</label>
                        <input name="url" class="form-control @error('url') is-invalid @enderror" 
                               value="{{ old('url', $store->url) }}" required />
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $store->email) }}" required />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave empty to keep current password</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No of Employees *</label>
                        <input name="no_of_employees" type="number" class="form-control @error('no_of_employees') is-invalid @enderror" 
                               value="{{ old('no_of_employees', $store->no_of_employees) }}" required min="1" />
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
                            <option value="monthly" {{ old('billing_period', $store->billing_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_period', $store->billing_period) == 'yearly' ? 'selected' : '' }}>Yearly</option>
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
                               value="{{ old('start_date', $store->start_date ? $store->start_date->format('Y-m-d') : '') }}" required />
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">End Date *</label>
                        <input name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date', $store->end_date ? $store->end_date->format('Y-m-d') : '') }}" required />
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Package *</label>
                <select name="package_id" class="form-control @error('package_id') is-invalid @enderror" required>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}" {{ old('package_id', $store->package_id) == $p->id ? 'selected' : '' }}>
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
                        <option value="{{ $businessType->id }}" {{ in_array($businessType->id, old('business_types', $store->businessTypes->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $businessType->name }}
                        </option>
                    @endforeach
                </select>
                @error('business_types')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Hold Ctrl/Cmd to select multiple business types</div>
            </div>

            <button class="btn btn-dark">Update Store</button>
            <a href="{{ route('admin.store.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection