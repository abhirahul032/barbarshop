<!-- Locations Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Locations</h5>
        <small class="text-muted">Choose the locations where this team member works</small>
    </div>
    <div class="section-body">
        @foreach($locations as $location)
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="location_{{ $location->id }}" 
                   name="locations[]" value="{{ $location->id }}"
                   {{ (isset($teamMember) && $teamMember->locations->contains($location->id)) ? 'checked' : '' }}>
            <label class="form-check-label" for="location_{{ $location->id }}">
                <strong>{{ $location->name }}</strong><br>
                <small class="text-muted">{{ $location->address ?? 'No address specified' }}</small>
            </label>
        </div>
        @endforeach
        
        @if($locations->isEmpty())
            <p class="text-muted">No locations available.</p>
        @endif
    </div>
</div>