@extends('admin.layouts.app')

@section('title','Edit Global Service')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Edit Global Service</h4>
    <a href="{{ route('admin.global-service.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Display Validation Errors -->
@include('admin.layouts.error')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.global-service.update', $globalService->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Business Type *</label>
                        <select name="business_type_id" class="form-control @error('business_type_id') is-invalid @enderror" required>
                            <option value="">Select Business Type</option>
                            @foreach($businessTypes as $type)
                                <option value="{{ $type->id }}" {{ old('business_type_id', $globalService->business_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('business_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Service Name *</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $globalService->name) }}" required placeholder="e.g., Haircut, Manicure, Massage" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="3" placeholder="Service description">{{ old('description', $globalService->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <input name="category" class="form-control @error('category') is-invalid @enderror" 
                               value="{{ old('category', $globalService->category) }}" required placeholder="e.g., Hair, Nails, Spa" />
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Service Type *</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" id="serviceType" required>
                            <option value="fixed" {{ old('type', $globalService->type) == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                            <option value="hourly" {{ old('type', $globalService->type) == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Duration (minutes) *</label>
                        <input type="number" name="duration_minutes" class="form-control @error('duration_minutes') is-invalid @enderror" 
                               value="{{ old('duration_minutes', $globalService->duration_minutes) }}" min="1" required />
                        @error('duration_minutes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                
                <?php #echo $globalService->price." == >".$globalService->hourly_price; ?>
                
                <div class="col-md-6">
                    <div class="mb-3" id="priceField">
                        <label class="form-label">Price ($) *</label>
                        <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price', $globalService->price) }}" min="0" />
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3" id="hourlyPriceField">
                        <label class="form-label">Hourly Price ($) *</label>
                        <input type="number" step="0.01" name="hourly_price" class="form-control @error('hourly_price') is-invalid @enderror" 
                               value="{{ old('hourly_price', $globalService->hourly_price) }}" min="0" />
                        @error('hourly_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', $globalService->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Active
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-dark">Update Service</button>
            <a href="{{ route('admin.global-service.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceTypeSelect = document.getElementById('serviceType');
    const priceField = document.getElementById('priceField');
    const hourlyPriceField = document.getElementById('hourlyPriceField');
    
    function togglePriceFields() {
        const type = serviceTypeSelect.value;
        
        if (type === 'fixed') {
            priceField.style.display = 'block';
            hourlyPriceField.style.display = 'none';
            priceField.querySelector('input').required = true;
            hourlyPriceField.querySelector('input').required = false;
        } else {
            priceField.style.display = 'none';
            hourlyPriceField.style.display = 'block';
            priceField.querySelector('input').required = false;
            hourlyPriceField.querySelector('input').required = true;
        }
    }
    
    serviceTypeSelect.addEventListener('change', togglePriceFields);
    
    // Trigger on page load to set initial state
    togglePriceFields();
});
</script>

@endsection