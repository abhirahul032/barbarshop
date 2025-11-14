@extends('store.layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <!-- Display Validation Errors -->
            @include('store.layouts.error')

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Service: {{ $service->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Service Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $service->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-control @error('category') is-invalid @enderror" 
                                            id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="hair" {{ old('category', $service->category) == 'hair' ? 'selected' : '' }}>Hair Cut & Styling</option>
                                        <option value="coloring" {{ old('category', $service->category) == 'coloring' ? 'selected' : '' }}>Hair Coloring</option>
                                        <option value="beard" {{ old('category', $service->category) == 'beard' ? 'selected' : '' }}>Beard Services</option>
                                        <option value="spa" {{ old('category', $service->category) == 'spa' ? 'selected' : '' }}>Spa & Facial</option>
                                        <option value="massage" {{ old('category', $service->category) == 'massage' ? 'selected' : '' }}>Massage</option>
                                        <option value="waxing" {{ old('category', $service->category) == 'waxing' ? 'selected' : '' }}>Waxing</option>
                                        <option value="other" {{ old('category', $service->category) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($) *</label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $service->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="duration_minutes" class="form-label">Duration (minutes) *</label>
                                    <select class="form-control @error('duration_minutes') is-invalid @enderror" 
                                            id="duration_minutes" name="duration_minutes" required>
                                        <option value="">Select Duration</option>
                                        <option value="15" {{ old('duration_minutes', $service->duration_minutes) == '15' ? 'selected' : '' }}>15 minutes</option>
                                        <option value="30" {{ old('duration_minutes', $service->duration_minutes) == '30' ? 'selected' : '' }}>30 minutes</option>
                                        <option value="45" {{ old('duration_minutes', $service->duration_minutes) == '45' ? 'selected' : '' }}>45 minutes</option>
                                        <option value="60" {{ old('duration_minutes', $service->duration_minutes) == '60' ? 'selected' : '' }}>1 hour</option>
                                        <option value="90" {{ old('duration_minutes', $service->duration_minutes) == '90' ? 'selected' : '' }}>1.5 hours</option>
                                        <option value="120" {{ old('duration_minutes', $service->duration_minutes) == '120' ? 'selected' : '' }}>2 hours</option>
                                        <option value="180" {{ old('duration_minutes', $service->duration_minutes) == '180' ? 'selected' : '' }}>3 hours</option>
                                    </select>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="8" 
                                              placeholder="Describe the service in detail...">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                            {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Service is active and available for booking
                                        </label>
                                    </div>
                                </div>

                                <!-- Service Statistics -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Service Statistics</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Total Employees</small>
                                                <div class="h5">{{ $service->employees()->count() }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Created</small>
                                                <div class="h6">{{ $service->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Service</button>
                            <a href="{{ route('store.services.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add real-time duration display
    const durationSelect = document.getElementById('duration_minutes');
    const durationDisplay = document.createElement('div');
    durationDisplay.className = 'form-text mt-1';
    durationSelect.parentNode.appendChild(durationDisplay);

    function updateDurationDisplay() {
        const minutes = parseInt(durationSelect.value);
        if (minutes) {
            const hours = Math.floor(minutes / 60);
            const remainingMinutes = minutes % 60;
            
            if (hours > 0) {
                durationDisplay.textContent = `${hours} hour${hours > 1 ? 's' : ''}${remainingMinutes > 0 ? ` and ${remainingMinutes} minute${remainingMinutes > 1 ? 's' : ''}` : ''}`;
            } else {
                durationDisplay.textContent = `${minutes} minute${minutes > 1 ? 's' : ''}`;
            }
        } else {
            durationDisplay.textContent = '';
        }
    }

    durationSelect.addEventListener('change', updateDurationDisplay);
    updateDurationDisplay(); // Initial call
});
</script>
@endsection