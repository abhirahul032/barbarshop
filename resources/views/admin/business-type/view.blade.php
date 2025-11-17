@extends('admin.layouts.app')

@section('title', 'Business Type Details')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Business Type Details</h4>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="ri-add-line"></i> Add Service
        </button>
        <a href="{{ route('admin.business-type.edit', $businessType->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.business-type.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $businessType->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $businessType->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $businessType->description ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($businessType->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $businessType->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $businessType->updated_at->format('M d, Y H:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Global Services Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Services</h5>
                <span class="badge bg-primary">{{ $globalServices->total() }} Services</span>
            </div>
            <div class="card-body">
                @if($globalServices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($globalServices as $service)
                                    <tr>
                                        <td>
                                            <strong>{{ $service->name }}</strong>
                                            @if($service->description)
                                                <br><small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $service->category }}</td>
                                        <td>
                                            <span class="badge bg-{{ $service->type == 'fixed' ? 'primary' : 'info' }}">
                                                {{ ucfirst($service->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $service->formatted_price }}</td>
                                        <td>{{ $service->formatted_duration }}</td>
                                        <td>
                                            @if($service->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.global-service.edit', $service->id) }}" 
                                                   class="btn btn-sm btn-outline-secondary" 
                                                   title="Edit Service">
                                                    <i class="ri-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('admin.global-service.destroy', $service->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this service?')"
                                                            title="Delete Service">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($globalServices->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Showing {{ $globalServices->firstItem() ?? 0 }} to {{ $globalServices->lastItem() ?? 0 }} of {{ $globalServices->total() }} services
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($globalServices->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $globalServices->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($globalServices->getUrlRange(1, $globalServices->lastPage()) as $page => $url)
                                    @if ($page == $globalServices->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($globalServices->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $globalServices->nextPageUrl() }}" rel="next">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="ri-inbox-line ri-3x text-muted"></i>
                        <p class="text-muted mt-2">No services found for this business type.</p>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                            <i class="ri-add-line"></i> Add First Service
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add New Service to {{ $businessType->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.global-service.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="business_type_id" value="{{ $businessType->id }}">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Service Name *</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required placeholder="e.g., Haircut, Manicure, Massage" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <input name="category" class="form-control @error('category') is-invalid @enderror" 
                                       value="{{ old('category') }}" required placeholder="e.g., Hair, Nails, Spa" />
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Service description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Service Type *</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" id="serviceType" required>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                    <option value="hourly" {{ old('type') == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
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
                                       value="{{ old('duration_minutes', 60) }}" min="1" required />
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3" id="priceField">
                                <label class="form-label">Price ($) *</label>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', 0) }}" min="0" />
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3" id="hourlyPriceField" style="display: none;">
                                <label class="form-label">Hourly Price ($) *</label>
                                <input type="number" step="0.01" name="hourly_price" class="form-control @error('hourly_price') is-invalid @enderror" 
                                       value="{{ old('hourly_price', 0) }}" min="0" />
                                @error('hourly_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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
    
    // Trigger on page load
    togglePriceFields();
    
    // Handle modal show event to clear previous validation
    const addServiceModal = document.getElementById('addServiceModal');
    addServiceModal.addEventListener('show.bs.modal', function () {
        // Clear any existing validation errors
        const invalidFields = this.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        const invalidFeedback = this.querySelectorAll('.invalid-feedback');
        invalidFeedback.forEach(feedback => {
            feedback.remove();
        });
    });
    
    // Handle form submission success
    const form = addServiceModal.querySelector('form');
    form.addEventListener('submit', function(e) {
        // You can add any pre-submission logic here
        // The form will submit normally and refresh the page
    });
});
</script>
@endpush