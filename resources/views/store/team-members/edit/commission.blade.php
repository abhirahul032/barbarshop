<!-- resources/views/team-members/partials/commission.blade.php -->

<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Commissions</h5>
    </div>
    <div class="section-body">
        <!-- Services Commission -->
        <div class="commission-section mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Services commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="services_commission_enabled" 
                           name="services_commission_enabled" value="1"
                           {{ ($commission->services_commission_enabled ?? true) ? 'checked' : '' }}>
                </div>
            </div>
            <p class="text-muted">Commission earned on services provided. <a href="#">Learn more</a></p>
            
            <div id="services_commission_fields" style="display: {{ ($commission->services_commission_enabled ?? true) ? 'block' : 'none' }};">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="services_commission_type" class="form-label">Default commission type</label>
                        <select class="form-select" id="services_commission_type" name="services_commission_type">
                            <option value="fixed_rate" {{ ($commission->services_commission_type ?? 'fixed_rate') === 'fixed_rate' ? 'selected' : '' }}>Fixed rate</option>
                            <option value="percentage" {{ ($commission->services_commission_type ?? 'fixed_rate') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="services_default_rate" class="form-label">Default rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="services_default_rate" 
                                   name="services_default_rate" value="{{ $commission->services_default_rate ?? 0 }}" 
                                   step="0.01" min="0">
                            <span class="input-group-text" id="services_rate_suffix">
                                {{ ($commission->services_commission_type ?? 'fixed_rate') === 'percentage' ? '%' : '$' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Customize commissions by service</h6>
                    <p class="text-muted">{{ $services->count() }} services on default rate</p>
                    <!-- You can add a table here to override individual service commissions -->
                </div>

                <div class="mb-3">
                    <h6>Calculations</h6>
                    <p class="text-muted">Customize deductions for this team member. <a href="#">Learn more</a></p>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="services_calculation_type" 
                               id="services_default_settings" value="default"
                               {{ ($commission->services_calculation_type ?? 'default') === 'default' ? 'checked' : '' }}>
                        <label class="form-check-label" for="services_default_settings">
                            Default settings<br>
                            <small class="text-muted">Use your workspace commission settings</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="services_calculation_type" 
                               id="services_custom_settings" value="custom"
                               {{ ($commission->services_calculation_type ?? 'default') === 'custom' ? 'checked' : '' }}>
                        <label class="form-check-label" for="services_custom_settings">
                            Custom settings<br>
                            <small class="text-muted">Choose custom settings for this team member</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Commission -->
        <div class="commission-section mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Products commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="products_commission_enabled" 
                           name="products_commission_enabled" value="1"
                           {{ ($commission->products_commission_enabled ?? false) ? 'checked' : '' }}>
                </div>
            </div>
            <p class="text-muted">Commission earned on products sold. <a href="#">Learn more</a></p>
            
            <div id="products_commission_fields" style="display: {{ ($commission->products_commission_enabled ?? false) ? 'block' : 'none' }};">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="products_commission_type" class="form-label">Default commission type</label>
                        <select class="form-select" id="products_commission_type" name="products_commission_type">
                            <option value="fixed_rate" {{ ($commission->products_commission_type ?? 'fixed_rate') === 'fixed_rate' ? 'selected' : '' }}>Fixed rate</option>
                            <option value="percentage" {{ ($commission->products_commission_type ?? 'fixed_rate') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="products_default_rate" class="form-label">Default rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="products_default_rate" 
                                   name="products_default_rate" value="{{ $commission->products_default_rate ?? 0 }}" 
                                   step="0.01" min="0">
                            <span class="input-group-text" id="products_rate_suffix">
                                {{ ($commission->products_commission_type ?? 'fixed_rate') === 'percentage' ? '%' : '$' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Customize commissions by product</h6>
                    <p class="text-muted">No products in your catalog</p>
                </div>

                <div class="mb-3">
                    <h6>Calculations</h6>
                    <p class="text-muted">Customize deductions for this team member. <a href="#">Learn more</a></p>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="products_calculation_type" 
                               id="products_default_settings" value="default"
                               {{ ($commission->products_calculation_type ?? 'default') === 'default' ? 'checked' : '' }}>
                        <label class="form-check-label" for="products_default_settings">
                            Default settings<br>
                            <small class="text-muted">Use your workspace commission settings</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="products_calculation_type" 
                               id="products_custom_settings" value="custom"
                               {{ ($commission->products_calculation_type ?? 'default') === 'custom' ? 'checked' : '' }}>
                        <label class="form-check-label" for="products_custom_settings">
                            Custom settings<br>
                            <small class="text-muted">Choose custom settings for this team member</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memberships Commission -->
        <div class="commission-section mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Memberships commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="memberships_commission_enabled" 
                           name="memberships_commission_enabled" value="1"
                           {{ ($commission->memberships_commission_enabled ?? false) ? 'checked' : '' }}>
                </div>
            </div>
            <p class="text-muted">Commission earned on memberships sold. <a href="#">Learn more</a></p>
            
            <div id="memberships_commission_fields" style="display: {{ ($commission->memberships_commission_enabled ?? false) ? 'block' : 'none' }};">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="memberships_commission_type" class="form-label">Default commission type</label>
                        <select class="form-select" id="memberships_commission_type" name="memberships_commission_type">
                            <option value="fixed_rate" {{ ($commission->memberships_commission_type ?? 'fixed_rate') === 'fixed_rate' ? 'selected' : '' }}>Fixed rate</option>
                            <option value="percentage" {{ ($commission->memberships_commission_type ?? 'fixed_rate') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="memberships_default_rate" class="form-label">Default rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="memberships_default_rate" 
                                   name="memberships_default_rate" value="{{ $commission->memberships_default_rate ?? 0 }}" 
                                   step="0.01" min="0">
                            <span class="input-group-text" id="memberships_rate_suffix">
                                {{ ($commission->memberships_commission_type ?? 'fixed_rate') === 'percentage' ? '%' : '$' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Customize commissions by membership</h6>
                    <p class="text-muted">No memberships in your catalog</p>
                </div>

                <div class="mb-3">
                    <h6>Calculations</h6>
                    <p class="text-muted">Customize deductions for this team member. <a href="#">Learn more</a></p>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="memberships_calculation_type" 
                               id="memberships_default_settings" value="default"
                               {{ ($commission->memberships_calculation_type ?? 'default') === 'default' ? 'checked' : '' }}>
                        <label class="form-check-label" for="memberships_default_settings">
                            Default settings<br>
                            <small class="text-muted">Use your workspace commission settings</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="memberships_calculation_type" 
                               id="memberships_custom_settings" value="custom"
                               {{ ($commission->memberships_calculation_type ?? 'default') === 'custom' ? 'checked' : '' }}>
                        <label class="form-check-label" for="memberships_custom_settings">
                            Custom settings<br>
                            <small class="text-muted">Choose custom settings for this team member</small>
                        </label>
                    </div>
                    
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="memberships_deduct_discounts" 
                               name="memberships_deduct_discounts" value="1"
                               {{ ($commission->memberships_deduct_discounts ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="memberships_deduct_discounts">
                            Deduct discounts<br>
                            <small class="text-muted">Deduct discounts from sale price prior to calculating commission</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="memberships_deduct_taxes" 
                               name="memberships_deduct_taxes" value="1"
                               {{ ($commission->memberships_deduct_taxes ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="memberships_deduct_taxes">
                            Deduct taxes<br>
                            <small class="text-muted">Deduct taxes from sale price prior to calculating commission</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gift Cards Commission -->
        <div class="commission-section mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Gift cards commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="gift_cards_commission_enabled" 
                           name="gift_cards_commission_enabled" value="1"
                           {{ ($commission->gift_cards_commission_enabled ?? false) ? 'checked' : '' }}>
                </div>
            </div>
            <p class="text-muted">Commission earned on gift cards sold. <a href="#">Learn more</a></p>
            
            <div id="gift_cards_commission_fields" style="display: {{ ($commission->gift_cards_commission_enabled ?? false) ? 'block' : 'none' }};">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="gift_cards_commission_type" class="form-label">Default commission type</label>
                        <select class="form-select" id="gift_cards_commission_type" name="gift_cards_commission_type">
                            <option value="fixed_rate" {{ ($commission->gift_cards_commission_type ?? 'fixed_rate') === 'fixed_rate' ? 'selected' : '' }}>Fixed rate</option>
                            <option value="percentage" {{ ($commission->gift_cards_commission_type ?? 'fixed_rate') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="gift_cards_default_rate" class="form-label">Default rate</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="gift_cards_default_rate" 
                                   name="gift_cards_default_rate" value="{{ $commission->gift_cards_default_rate ?? 0 }}" 
                                   step="0.01" min="0">
                            <span class="input-group-text" id="gift_cards_rate_suffix">
                                {{ ($commission->gift_cards_commission_type ?? 'fixed_rate') === 'percentage' ? '%' : '$' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6>Calculations</h6>
                    <p class="text-muted">Customize deductions for this team member. <a href="#">Learn more</a></p>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gift_cards_calculation_type" 
                               id="gift_cards_default_settings" value="default"
                               {{ ($commission->gift_cards_calculation_type ?? 'default') === 'default' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gift_cards_default_settings">
                            Default settings<br>
                            <small class="text-muted">Use your workspace commission settings</small>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gift_cards_calculation_type" 
                               id="gift_cards_custom_settings" value="custom"
                               {{ ($commission->gift_cards_calculation_type ?? 'default') === 'custom' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gift_cards_custom_settings">
                            Custom settings<br>
                            <small class="text-muted">Choose custom settings for this team member</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancellation Commission -->
        <div class="commission-section mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Cancellation commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="cancellation_commission_enabled" 
                           name="cancellation_commission_enabled" value="1"
                           {{ ($commission->cancellation_commission_enabled ?? false) ? 'checked' : '' }}>
                </div>
            </div>
            <p class="text-muted">Commission earned on fees for no-shows and late cancellations. <a href="#">Learn more</a></p>
            
            <div id="cancellation_commission_fields" style="display: {{ ($commission->cancellation_commission_enabled ?? false) ? 'block' : 'none' }};">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="late_cancellation_fee" 
                           name="late_cancellation_fee" value="1"
                           {{ ($commission->late_cancellation_fee ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="late_cancellation_fee">
                        Pass on the cancellation fee for late cancellations<br>
                        <small class="text-muted">When the client cancels late, the team member earns a portion of the cancellation fee</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="no_show_fee" 
                           name="no_show_fee" value="1"
                           {{ ($commission->no_show_fee ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="no_show_fee">
                        Pass on the cancellation fee for no-shows<br>
                        <small class="text-muted">When the client is a no-show, the team member earns a portion of the fee</small>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end">
            <button type="button" id="saveCommissionBtn" class="btn btn-primary">
                <i class="fas fa-spinner fa-spin d-none"></i>
                Save Commission Settings
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle commission sections
    function toggleCommissionSection(sectionId, checkboxId) {
        const checkbox = document.getElementById(checkboxId);
        const section = document.getElementById(sectionId);
        
        if (checkbox && section) {
            section.style.display = checkbox.checked ? 'block' : 'none';
            
            // Add event listener
            checkbox.addEventListener('change', function() {
                section.style.display = this.checked ? 'block' : 'none';
            });
        }
    }

    // Toggle rate suffix based on commission type
    function setupCommissionTypeToggle(commissionTypeId, rateSuffixId) {
        const commissionType = document.getElementById(commissionTypeId);
        const rateSuffix = document.getElementById(rateSuffixId);
        
        if (commissionType && rateSuffix) {
            commissionType.addEventListener('change', function() {
                rateSuffix.textContent = this.value === 'percentage' ? '%' : '$';
            });
        }
    }

    // Initialize all commission sections
    toggleCommissionSection('services_commission_fields', 'services_commission_enabled');
    toggleCommissionSection('products_commission_fields', 'products_commission_enabled');
    toggleCommissionSection('memberships_commission_fields', 'memberships_commission_enabled');
    toggleCommissionSection('gift_cards_commission_fields', 'gift_cards_commission_enabled');
    toggleCommissionSection('cancellation_commission_fields', 'cancellation_commission_enabled');

    // Initialize commission type toggles
    setupCommissionTypeToggle('services_commission_type', 'services_rate_suffix');
    setupCommissionTypeToggle('products_commission_type', 'products_rate_suffix');
    setupCommissionTypeToggle('memberships_commission_type', 'memberships_rate_suffix');
    setupCommissionTypeToggle('gift_cards_commission_type', 'gift_cards_rate_suffix');

    // AJAX form submission
    document.getElementById('saveCommissionBtn').addEventListener('click', function() {
        const btn = this;
        const spinner = btn.querySelector('.fa-spinner');
        const originalText = btn.innerHTML;
        
        // Show loading state
        spinner.classList.remove('d-none');
        btn.disabled = true;
        btn.innerHTML = 'Saving...';

        // Collect form data
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        
        // Add all commission fields
        const commissionFields = [
            'services_commission_enabled', 'services_commission_type', 'services_default_rate', 'services_calculation_type',
            'products_commission_enabled', 'products_commission_type', 'products_default_rate', 'products_calculation_type',
            'memberships_commission_enabled', 'memberships_commission_type', 'memberships_default_rate', 'memberships_calculation_type',
            'memberships_deduct_discounts', 'memberships_deduct_taxes',
            'gift_cards_commission_enabled', 'gift_cards_commission_type', 'gift_cards_default_rate', 'gift_cards_calculation_type',
            'cancellation_commission_enabled', 'late_cancellation_fee', 'no_show_fee'
        ];

        commissionFields.forEach(field => {
            const element = document.querySelector(`[name="${field}"]`);
            if (element) {
                if (element.type === 'checkbox') {
                    formData.append(field, element.checked ? 1 : 0);
                } else if (element.type === 'radio') {
                    const selected = document.querySelector(`[name="${field}"]:checked`);
                    if (selected) formData.append(field, selected.value);
                } else {
                    formData.append(field, element.value);
                }
            }
        });

        // Send AJAX request
        fetch('{{ route("store.team-members.commission.store", $teamMember->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                throw new Error('Server returned non-JSON response. Status: ' + response.status);
            }
        })
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message || 'An error occurred');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while saving: ' + error.message);
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('d-none');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin d-none"></i>Save Commission Settings';
        });
    });

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insert at the top of the form
        const cardBody = document.querySelector('.section-body');
        cardBody.insertBefore(alert, cardBody.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>