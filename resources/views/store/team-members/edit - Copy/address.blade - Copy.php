<!-- Addresses Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Addresses</h5>
        <small class="text-muted">Manage your team member's correspondence addresses</small>
    </div>
    <div class="section-body">
        @if(isset($teamMember) && $teamMember->addresses->count() > 0)
            @foreach($teamMember->addresses as $address)
            <div class="border p-3 mb-3 rounded">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $address->address_name ?? 'Address' }}</h6>
                        <p class="mb-1 text-muted">{{ $address->full_address }}</p>
                    </div>
                    <form action="{{ route('store.team-members.addresses.destroy', [$teamMember->id, $address->id]) }}" method="POST">
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
            <p class="text-muted mb-3">No addresses added yet.</p>
        @endif
        
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
            <form action="{{ isset($teamMember) ? route('store.team-members.addresses.store', $teamMember) : '#' }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="address_name" class="form-label">Address name</label>
                        <input type="text" class="form-control" id="address_name" name="address_name">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="col-md-6">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="India">
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