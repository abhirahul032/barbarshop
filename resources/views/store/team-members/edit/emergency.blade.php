<!-- Emergency Contacts Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Emergency Contacts</h5>
        <small class="text-muted">Manage your team members' emergency contacts</small>
    </div>
    <div class="section-body">
        <div id="emergencyContactsContainer">
            @if(isset($teamMember) && $teamMember->emergencyContacts->count() > 0)
                @foreach($teamMember->emergencyContacts as $contact)
                <div class="border p-3 mb-3 rounded contact-item" data-contact-id="{{ $contact->id }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">{{ $contact->full_name }}</h6>
                            <p class="mb-1 text-muted">{{ $contact->relationship }}</p>
                            <p class="mb-1 text-muted">{{ $contact->phone_number }}</p>
                            @if($contact->email)
                            <p class="mb-0 text-muted">{{ $contact->email }}</p>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-contact" data-contact-id="{{ $contact->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-muted mb-3">No emergency contacts added yet.</p>
            @endif
        </div>
        
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addEmergencyContactModal">
            <i class="fa fa-plus me-2"></i>Add an emergency contact
        </button>
    </div>
</div>

<!-- Add Emergency Contact Modal -->
<div class="modal fade" id="addEmergencyContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Emergency Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addEmergencyContactForm">
                @csrf
                <div class="modal-body">
                    <div id="emergencyContactAlertContainer"></div>
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="e.g. John Hancock">
                    </div>
                    <div class="mb-3">
                        <label for="relationship" class="form-label">Relationship</label>
                        <select class="form-select" id="relationship" name="relationship">
                            <option value="">Select an option</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Friend">Friend</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">+91</span>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="e.g. +91 97810 50102">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveEmergencyContactBtn">
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
    // Add Emergency Contact Form Submission
    document.getElementById('addEmergencyContactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('saveEmergencyContactBtn');
        const spinner = btn.querySelector('.fa-spinner');
        const originalText = btn.innerHTML;
        
        // Show loading state
        spinner.classList.remove('d-none');
        btn.disabled = true;
        btn.innerHTML = 'Adding...';

        const formData = new FormData(this);
        
        fetch('{{ route("store.team-members.emergency-contacts.store", $teamMember) }}', {
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
                const modal = bootstrap.Modal.getInstance(document.getElementById('addEmergencyContactModal'));
                modal.hide();
                
                // Reset form
                document.getElementById('addEmergencyContactForm').reset();
                
                // Add new contact to container
                addContactToContainer(data.data);
                
                showAlert('success', data.message, 'emergencyContactAlertContainer');
            } else {
                showAlert('error', data.message, 'emergencyContactAlertContainer');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while adding contact: ' + error.message, 'emergencyContactAlertContainer');
        })
        .finally(() => {
            // Restore button state
            spinner.classList.add('d-none');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    // Delete Emergency Contact
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-contact') || e.target.closest('.delete-contact')) {
            const button = e.target.classList.contains('delete-contact') ? e.target : e.target.closest('.delete-contact');
            const contactId = button.dataset.contactId;
            
            if (confirm('Are you sure you want to delete this emergency contact?')) {
                deleteContact(contactId);
            }
        }
    });

    function addContactToContainer(contact) {
        const contactsContainer = document.getElementById('emergencyContactsContainer');
        const noContactsMessage = contactsContainer.querySelector('.text-muted');
        
        // Remove "no contacts" message if it exists
        if (noContactsMessage) {
            noContactsMessage.remove();
        }
        
        const contactHtml = `
            <div class="border p-3 mb-3 rounded contact-item" data-contact-id="${contact.id}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">${contact.full_name}</h6>
                        <p class="mb-1 text-muted">${contact.relationship}</p>
                        <p class="mb-1 text-muted">${contact.phone_number}</p>
                        ${contact.email ? `<p class="mb-0 text-muted">${contact.email}</p>` : ''}
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-contact" data-contact-id="${contact.id}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        contactsContainer.insertAdjacentHTML('beforeend', contactHtml);
    }

    function deleteContact(contactId) {
        // Use the correct route with both parameters
        const url = '{{ route("store.team-members.emergency-contacts.destroy", ["teamMember" => $teamMember->id, "emergencyContact" => "CONTACT_ID"]) }}'.replace('CONTACT_ID', contactId);
        
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
                // Remove contact from container
                const contactElement = document.querySelector(`.contact-item[data-contact-id="${contactId}"]`);
                if (contactElement) {
                    contactElement.remove();
                }
                
                // Show "no contacts" message if no contacts left
                const contactsContainer = document.getElementById('emergencyContactsContainer');
                if (contactsContainer.querySelectorAll('.contact-item').length === 0) {
                    contactsContainer.innerHTML = '<p class="text-muted mb-3">No emergency contacts added yet.</p>';
                }
                
                showAlert('success', data.message, 'emergencyContactsContainer');
            } else {
                showAlert('error', data.message, 'emergencyContactsContainer');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while deleting contact: ' + error.message, 'emergencyContactsContainer');
        });
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