<!-- Addresses Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Addresses</h5>
        <small class="text-muted">Manage your team member's correspondence addresses</small>
    </div>
    <div id="addressAlertContainer"></div>
    <div class="section-body">
        <div id="addressesContainer">
            @if(isset($teamMember) && $teamMember->addresses->count() > 0)
                @foreach($teamMember->addresses as $address)
                <div class="border p-3 mb-3 rounded address-item" data-address-id="{{ $address->id }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $address->address_name ?? 'Address' }}</h6>
                            <p class="mb-1 text-muted">
                                {{ $address->address }}{{ $address->city ? ', ' . $address->city : '' }}{{ $address->state ? ', ' . $address->state : '' }}{{ $address->postal_code ? ', ' . $address->postal_code : '' }}{{ $address->country ? ', ' . $address->country : '' }}
                            </p>
                            @if($address->is_primary)
                                <span class="badge bg-primary">Primary</span>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary set-primary-address" data-address-id="{{ $address->id }}">
                                    Set as Primary
                                </button>
                            @endif
                        </div>
                        <div class="ms-2">
                            <button type="button" class="btn btn-sm btn-outline-danger delete-address" data-address-id="{{ $address->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-muted mb-3">No addresses added yet.</p>
            @endif
        </div>
        
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="fa fa-plus me-2"></i>Add an address
        </button>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAddressForm">
                @csrf
                <div class="modal-body">
                    
                    
                    <div class="mb-3">
                        <label for="address_name" class="form-label">Address name</label>
                        <input type="text" class="form-control" id="address_name" name="address_name" placeholder="e.g., Home, Office">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Street address" required></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="City">
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="State">
                        </div>
                        <div class="col-md-6">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Postal Code">
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="India" placeholder="Country">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1">
                        <label class="form-check-label" for="is_primary">
                            Set as primary address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveAddressBtn">
                        <i class="fas fa-spinner fa-spin d-none"></i>
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Address Form Submission
    document.getElementById('addAddressForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('saveAddressBtn');
        const spinner = btn.querySelector('.fa-spinner');
        const originalText = btn.innerHTML;
        
        // Show loading state
        spinner.classList.remove('d-none');
        btn.disabled = true;
        btn.innerHTML = 'Adding...';

        const formData = new FormData(this);
        formData.append('is_primary', document.getElementById('is_primary').checked ? 1 : 0);
        
        fetch('{{ route("store.team-members.addresses.store", $teamMember) }}', {
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
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addAddressModal'));
                modal.hide();
                
                // Reset form
                document.getElementById('addAddressForm').reset();
                
                // Add new address to container
                addAddressToContainer(data.data);
                
                showAlert('success', data.message, 'addressAlertContainer');
            } else {
                showAlert('error', data.message, 'addressAlertContainer');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while adding address: ' + error.message, 'addressAlertContainer');
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('d-none');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    // Delete Address
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-address') || e.target.closest('.delete-address')) {
            const button = e.target.classList.contains('delete-address') ? e.target : e.target.closest('.delete-address');
            const addressId = button.dataset.addressId;
            
            if (confirm('Are you sure you want to delete this address?')) {
                deleteAddress(addressId);
            }
        }
    });

    function addAddressToContainer(address) {
        const addressesContainer = document.getElementById('addressesContainer');
        const noAddressesMessage = addressesContainer.querySelector('.text-muted');
        
        // Remove "no addresses" message if it exists
        if (noAddressesMessage) {
            noAddressesMessage.remove();
        }
        
        // Build the full address string
        const fullAddress = [
            address.address,
            address.city,
            address.state,
            address.postal_code,
            address.country
        ].filter(part => part).join(', ');
        
        const addressHtml = `
            <div class="border p-3 mb-3 rounded address-item" data-address-id="${address.id}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">${address.address_name || 'Address'}</h6>
                        <p class="mb-1 text-muted">${fullAddress}</p>
                        ${address.is_primary ? '<span class="badge bg-primary">Primary</span>' : ''}
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-address" data-address-id="${address.id}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        addressesContainer.insertAdjacentHTML('beforeend', addressHtml);
    }

    function deleteAddress(addressId) {
        // Use the correct route with both parameters
        const url = '{{ route("store.team-members.addresses.destroy", ["teamMember" => $teamMember->id, "address" => "ADDRESS_ID"]) }}'.replace('ADDRESS_ID', addressId);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove address from container
                const addressElement = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
                if (addressElement) {
                    addressElement.remove();
                }
                
                // Show "no addresses" message if no addresses left
                const addressesContainer = document.getElementById('addressesContainer');
                if (addressesContainer.querySelectorAll('.address-item').length === 0) {
                    addressesContainer.innerHTML = '<p class="text-muted mb-3">No addresses added yet.</p>';
                }
                
                showAlert('success', data.message, 'addressesContainer');
            } else {
                showAlert('error', data.message, 'addressesContainer');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while deleting address: ' + error.message, 'addressesContainer');
        });
    }
    // Add this to your JavaScript in address.blade.php
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('set-primary-address') || e.target.closest('.set-primary-address')) {
        const button = e.target.classList.contains('set-primary-address') ? e.target : e.target.closest('.set-primary-address');
        const addressId = button.dataset.addressId;
        
        setPrimaryAddress(addressId);
    }
});

function setPrimaryAddress(addressId) {
    // Use the correct route name
    const url = '{{ route("store.team-members.addresses.set-primary", ["teamMember" => $teamMember->id, "address" => "ADDRESS_ID"]) }}'.replace('ADDRESS_ID', addressId);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI to reflect the new primary address
            updatePrimaryAddressUI(addressId);
            showAlert('success', data.message, 'addressesContainer');
        } else {
            showAlert('error', data.message, 'addressesContainer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'An error occurred while setting primary address: ' + error.message, 'addressesContainer');
    });
}

function updatePrimaryAddressUI(newPrimaryAddressId) {
    // Remove primary badges from all addresses
    document.querySelectorAll('.address-item').forEach(item => {
        const badge = item.querySelector('.badge');
        const setPrimaryBtn = item.querySelector('.set-primary-address');
        
        if (badge) badge.remove();
        if (setPrimaryBtn) setPrimaryBtn.style.display = 'inline-block';
    });
    
    // Add primary badge to the new primary address
    const primaryAddress = document.querySelector(`.address-item[data-address-id="${newPrimaryAddressId}"]`);
    if (primaryAddress) {
        const setPrimaryBtn = primaryAddress.querySelector('.set-primary-address');
        if (setPrimaryBtn) setPrimaryBtn.style.display = 'none';
        
        const badge = document.createElement('span');
        badge.className = 'badge bg-primary';
        badge.textContent = 'Primary';
        primaryAddress.querySelector('.flex-grow-1').appendChild(badge);
    }
}
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