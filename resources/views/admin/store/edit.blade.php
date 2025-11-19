@extends('admin.layouts.app')

@section('title','Edit Store')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 1rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem 1rem 0 0 !important;
        padding: 1.5rem 2rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .section-title {
        color: #4a5568;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .logo-preview {
        width: 120px;
        height: 120px;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .logo-preview:hover {
        border-color: #667eea;
        background: #f0f4ff;
    }
    
    .logo-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    
    .current-logo {
        border: 3px solid #10b981;
        position: relative;
    }
    
    .current-logo::after {
        content: 'Current';
        position: absolute;
        top: 5px;
        right: 5px;
        background: #10b981;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.5rem;
        color: white;
        padding: 0.25rem 0.75rem;
    }
    
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 0.5rem;
    }
    
    .select2-container--bootstrap-5 .select2-dropdown {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Edit Store: {{ $store->name }}</h4>
            <div class="page-title-right">
                <a href="{{ route('admin.store.index') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@include('admin.layouts.error')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-transparent">
                <h5 class="card-title text-white mb-0">
                    <i class="fa fa-edit me-2"></i>Edit Store Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.store.update', $store->id) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- Store Basic Information -->
                    <div class="section-title">Basic Information</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Store Name *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-store text-muted"></i>
                                    </span>
                                    <input name="name" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $store->name) }}" required placeholder="Enter store name" />
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Store Logo</label>
                                <div class="d-flex align-items-start gap-3">
                                    @if($store->logo)
                                        <div class="logo-preview current-logo">
                                            <img src="{{ asset('storage/' . $store->logo) }}" alt="Current logo">
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*" />
                                        <label for="logoInput" class="logo-preview">
                                            <div class="logo-placeholder text-center">
                                                <i class="fa fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                <div class="small text-muted">Click to upload new logo</div>
                                            </div>
                                        </label>
                                        <div class="form-text text-center mt-2">Leave empty to keep current logo</div>
                                    </div>
                                </div>
                                @error('logo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Store URL *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-globe text-muted"></i>
                                    </span>
                                    <input name="url" class="form-control border-start-0 @error('url') is-invalid @enderror" 
                                           value="{{ old('url', $store->url) }}" required />
                                </div>
                                @error('url')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Email Address *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-envelope text-muted"></i>
                                    </span>
                                    <input name="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $store->email) }}" required />
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Store Configuration -->
                    <div class="section-title">Store Configuration</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-lock text-muted"></i>
                                    </span>
                                    <input name="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                           placeholder="Enter new password" />
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty to keep current password</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Number of Employees *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-users text-muted"></i>
                                    </span>
                                    <input name="no_of_employees" type="number" class="form-control border-start-0 @error('no_of_employees') is-invalid @enderror" 
                                           value="{{ old('no_of_employees', $store->no_of_employees) }}" required min="1" />
                                </div>
                                @error('no_of_employees')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Billing & Subscription -->
                    <div class="section-title">Billing & Subscription</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label">Billing Period *</label>
                                <select name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" required>
                                    <option value="">Select Billing Period</option>
                                    <option value="monthly" {{ old('billing_period', $store->billing_period) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ old('billing_period', $store->billing_period) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                                @error('billing_period')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label">Start Date *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-calendar text-muted"></i>
                                    </span>
                                    <input name="start_date" type="date" class="form-control border-start-0 @error('start_date') is-invalid @enderror" 
                                           value="{{ old('start_date', $store->start_date ? $store->start_date->format('Y-m-d') : '') }}" required />
                                </div>
                                @error('start_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label">End Date *</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa fa-calendar-check text-muted"></i>
                                    </span>
                                    <input name="end_date" type="date" class="form-control border-start-0 @error('end_date') is-invalid @enderror" 
                                           value="{{ old('end_date', $store->end_date ? $store->end_date->format('Y-m-d') : '') }}" required />
                                </div>
                                @error('end_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Package *</label>
                                <select name="package_id" class="form-control @error('package_id') is-invalid @enderror" required>
                                    @foreach($packages as $p)
                                        <option value="{{ $p->id }}" {{ old('package_id', $store->package_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} - ${{ number_format($p->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label">Business Types *</label>
                                <select name="business_types[]" class="form-control select2-multiple @error('business_types') is-invalid @enderror" multiple="multiple" required>
                                    @foreach($businessTypes as $businessType)
                                        <option value="{{ $businessType->id }}" {{ in_array($businessType->id, old('business_types', $store->businessTypes->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $businessType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('business_types')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select one or more business types</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save me-2"></i>Update Store
                            </button>
                            <a href="{{ route('admin.store.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fa fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2-multiple').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select business types',
            allowClear: true,
            width: '100%'
        });

        // Password toggle
        $('#togglePassword').click(function() {
            const passwordInput = $('input[name="password"]');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        // Logo preview for new upload
        $('#logoInput').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.logo-preview').html(`<img src="${e.target.result}" alt="New logo preview">`);
                }
                reader.readAsDataURL(file);
            }
        });

        // Date validation
        $('input[name="start_date"], input[name="end_date"]').change(function() {
            const startDate = new Date($('input[name="start_date"]').val());
            const endDate = new Date($('input[name="end_date"]').val());
            
            if (startDate && endDate && startDate >= endDate) {
                alert('End date must be after start date');
                $('input[name="end_date"]').val('');
            }
        });
    });
</script>
@endpush