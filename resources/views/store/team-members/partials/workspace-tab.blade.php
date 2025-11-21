<form id="teamMemberForm"
      action="{{ isset($teamMember) ? route('store.team-members.update', $teamMember) : '' }}"
      method="POST">
     
    @csrf
    @if(isset($teamMember))
        @method('PUT')
    @endif
<div style="margin-bottom: 20px;" class="d-flex justify-content-end">
    <a href="{{ route('store.team-members.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
    <button type="submit" form="teamMemberForm" class="btn btn-primary">Update Team Member</button>
</div>
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Services</h5>
        <small class="text-muted">Choose the services this team member provides</small>
    </div>
    <div class="section-body">
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Search services">
        </div>
        
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="all_services" name="services[]" value="all">
            <label class="form-check-label fw-bold" for="all_services">
                All services
            </label>
        </div>
        
        @foreach($services as $service)
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="service_{{ $service->id }}" 
                   name="services[]" value="{{ $service->id }}"
                   {{ (isset($teamMember) && $teamMember->services->contains($service->id)) ? 'checked' : '' }}>
            <label class="form-check-label" for="service_{{ $service->id }}">
                {{ $service->name }} ({{ $service->duration_minutes }}min)
            </label>
        </div>
        @endforeach
        
        @if($services->isEmpty())
        <p class="text-muted">No services available. <a href="#">Add services first</a>.</p>
        @endif
    </div>
</div>


</form>