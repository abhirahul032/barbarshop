<div class="container mt-4">
   
    
    <div class="card section-card">
        <div class="section-header">
            <h5 class="mb-0">Services</h5>
            <small class="text-muted">Choose the services this team member provides</small>
        </div>
        <div class="section-body">
            <div id="servicesAlertContainer"></div>
            
            <div class="mb-3">
                <input type="text" class="form-control" id="serviceSearch" placeholder="Search services">
            </div>
            
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="all_services">
                <label class="form-check-label fw-bold" for="all_services">
                    All services
                </label>
            </div>
            
            <div id="servicesContainer">
                @foreach($services as $service)
                <div class="form-check mb-2 service-item" data-service-name="{{ strtolower($service->name) }}">
                    <input class="form-check-input service-checkbox" type="checkbox" id="service_{{ $service->id }}" 
                           name="services[]" value="{{ $service->id }}"
                           {{ (isset($teamMember) && $teamMember->services->contains($service->id)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="service_{{ $service->id }}">
                        {{ $service->name }} ({{ $service->duration_minutes }}min)
                    </label>
                </div>
                @endforeach
            </div>
            
            <div id="noResults" class="no-results" style="display: none">
                No services match your search.
            </div>
            
            @if($services->isEmpty())
            <p class="text-muted">No services available. <a href="#">Add services first</a>.</p>
            @endif
        </div>
        
         <div style="margin-bottom: 20px;" class="d-flex justify-content-end">
            
            <button type="button" id="saveServicesBtn" class="btn btn-primary">
                <i class="fas fa-spinner fa-spin d-none"></i>
                Update Services
            </button>
        </div>
        
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Save Services Button
    document.getElementById('saveServicesBtn').addEventListener('click', function() {
        const btn = this;
        const spinner = btn.querySelector('.fa-spinner');
        const originalText = btn.innerHTML;
        
        // Show loading state
        spinner.classList.remove('d-none');
        btn.disabled = true;
        btn.innerHTML = 'Updating...';

        // Collect selected services
        const selectedServices = [];
        document.querySelectorAll('.service-checkbox:checked').forEach(checkbox => {
            selectedServices.push(checkbox.value);
        });

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        selectedServices.forEach(serviceId => {
            formData.append('services[]', serviceId);
        });

        fetch('{{ route("store.team-members.updateservices", $teamMember) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message, 'servicesAlertContainer');
            } else {
                showAlert('error', data.message, 'servicesAlertContainer');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while updating services: ' + error.message, 'servicesAlertContainer');
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('d-none');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    // Search functionality
    $('#serviceSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        let visibleCount = 0;
        
        // Show/hide services based on search term
        $('.service-item').each(function() {
            const serviceName = $(this).data('service-name');
            
            if (serviceName.includes(searchTerm)) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });
        
        // Show/hide "All services" checkbox
        if (searchTerm.length > 0) {
            $('#all_services').closest('.form-check').hide();
        } else {
            $('#all_services').closest('.form-check').show();
        }
        
        // Show/hide no results message
        if (visibleCount === 0 && searchTerm.length > 0) {
            $('#noResults').show();
        } else {
            $('#noResults').hide();
        }
    });
    
    // "All services" checkbox functionality
    $('#all_services').on('change', function() {
        const isChecked = $(this).is(':checked');
        
        // Check/uncheck all service checkboxes
        $('.service-checkbox').prop('checked', isChecked);
    });
    
    // When individual service checkboxes change, update "All services" checkbox
    $('.service-checkbox').on('change', function() {
        const totalServices = $('.service-checkbox').length;
        const checkedServices = $('.service-checkbox:checked').length;
        
        if (checkedServices === totalServices) {
            $('#all_services').prop('checked', true);
        } else {
            $('#all_services').prop('checked', false);
        }
    });

    function showAlert(type, message, containerId) {
        const container = document.getElementById(containerId);
        
        // Remove existing alerts
        const existingAlerts = container.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show mb-3`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at the top of the container
        container.insertBefore(alert, container.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
@endpush