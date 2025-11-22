<div class="container mt-4">
        <form id="teamMemberFormservices" action="{{ route('store.team-members.updateservices', $teamMember) }}" method="POST">
            @csrf
            @if(isset($teamMember))
                @method('PUT')
            @endif
            
            <div style="margin-bottom: 20px;" class="d-flex justify-content-end">
                <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                <button type="submit" form="teamMemberFormservices" class="btn btn-primary">Update Team Member</button>
            </div>
            
            <div class="card section-card">
                <div class="section-header">
                    <h5 class="mb-0">Services</h5>
                    <small class="text-muted">Choose the services this team member provides</small>
                </div>
              <div class="section-body">
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
            </div>
        </form>
    </div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
        $(document).ready(function() {
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
        });
    </script>
    @endpush