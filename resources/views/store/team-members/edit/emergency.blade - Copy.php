<!-- Emergency Contacts Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Emergency Contacts</h5>
        <small class="text-muted">Manage your team members' emergency contacts</small>
    </div>
    <div class="section-body">
        @if(isset($teamMember) && $teamMember->emergencyContacts->count() > 0)
            @foreach($teamMember->emergencyContacts as $contact)
            <div class="border p-3 mb-3 rounded">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $contact->full_name }}</h6>
                        <p class="mb-1 text-muted">{{ $contact->relationship }}</p>
                        <p class="mb-1 text-muted">{{ $contact->phone_number }}</p>
                        @if($contact->email)
                        <p class="mb-0 text-muted">{{ $contact->email }}</p>
                        @endif
                    </div>
                    <form action="{{ route('store.team-members.emergency-contacts.destroy', ['teamMember' => $teamMember, 'emergencyContact' => $contact]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-muted mb-3">No emergency contacts added yet.</p>
        @endif
        
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
            <form action="{{ isset($teamMember) ? route('store.team-members.emergency-contacts.store', $teamMember) : '#' }}" method="POST">
                @csrf
                <div class="modal-body">
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
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>