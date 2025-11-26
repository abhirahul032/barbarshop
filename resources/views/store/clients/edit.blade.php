@extends('store.layouts.app')

@section('title', 'Edit Client - ' . $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa fa-edit text-warning me-2"></i>
                Edit Client - {{ $client->first_name }} {{ $client->last_name }}
            </h1>
            <p class="text-muted">Update client information and settings</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('store.clients.show', $client) }}" class="btn btn-outline-primary">
                <i class="fa fa-eye me-2"></i>View Profile
            </a>
            <a href="{{ route('store.clients.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back to Clients
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('store.clients.update', $client) }}" id="clientForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">
                            <i class="fa fa-user me-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name', $client->first_name) }}" 
                                           placeholder="e.g. John" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name', $client->last_name) }}" 
                                           placeholder="e.g. Hancock" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $client->email) }}" 
                                           placeholder="example@domain.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" 
                                           value="{{ old('phone', $client->phone) }}" 
                                           placeholder="+1 234 567 8901">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                                           id="birthday" name="birthday" 
                                           value="{{ old('birthday', $client->birthday ? $client->birthday->format('Y-m-d') : '') }}">
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select an option</option>
                                        <option value="male" {{ old('gender', $client->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $client->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $client->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', $client->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pronouns" class="form-label">Pronouns</label>
                            <select class="form-select @error('pronouns') is-invalid @enderror" id="pronouns" name="pronouns">
                                <option value="">Select an option</option>
                                <option value="he/him" {{ old('pronouns', $client->pronouns) == 'he/him' ? 'selected' : '' }}>He/Him</option>
                                <option value="she/her" {{ old('pronouns', $client->pronouns) == 'she/her' ? 'selected' : '' }}>She/Her</option>
                                <option value="they/them" {{ old('pronouns', $client->pronouns) == 'they/them' ? 'selected' : '' }}>They/Them</option>
                                <option value="ze/zir" {{ old('pronouns', $client->pronouns) == 'ze/zir' ? 'selected' : '' }}>Ze/Zir</option>
                                <option value="other" {{ old('pronouns', $client->pronouns) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('pronouns')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0">
                            <i class="fa fa-info-circle me-2"></i>Additional Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_source" class="form-label">Client Source</label>
                                    <select class="form-select @error('client_source') is-invalid @enderror" id="client_source" name="client_source">
                                        <option value="walk-in" {{ old('client_source', $client->client_source) == 'walk-in' ? 'selected' : '' }}>Walk-in</option>
                                        <option value="referral" {{ old('client_source', $client->client_source) == 'referral' ? 'selected' : '' }}>Referral</option>
                                        <option value="website" {{ old('client_source', $client->client_source) == 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="social-media" {{ old('client_source', $client->client_source) == 'social-media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="email-marketing" {{ old('client_source', $client->client_source) == 'email-marketing' ? 'selected' : '' }}>Email Marketing</option>
                                        <option value="other" {{ old('client_source', $client->client_source) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <small class="form-text text-muted">Choose how this client found your business.</small>
                                    @error('client_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="referred_by_client_id" class="form-label">Referred By</label>
                                    <select class="form-select @error('referred_by_client_id') is-invalid @enderror" 
                                            id="referred_by_client_id" name="referred_by_client_id">
                                        <option value="">Select a client</option>
                                        @foreach($existingClients as $existingClient)
                                            <option value="{{ $existingClient->id }}" 
                                                {{ old('referred_by_client_id', $client->referred_by_client_id) == $existingClient->id ? 'selected' : '' }}>
                                                {{ $existingClient->first_name }} {{ $existingClient->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Choose who referred this client to your business.</small>
                                    @error('referred_by_client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                           id="occupation" name="occupation" 
                                           value="{{ old('occupation', $client->occupation) }}" 
                                           placeholder="Enter client job information">
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select @error('country') is-invalid @enderror" id="country" name="country">
                                        <option value="">Select country</option>
                                        <option value="US" {{ old('country', $client->country) == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="UK" {{ old('country', $client->country) == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="CA" {{ old('country', $client->country) == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="AU" {{ old('country', $client->country) == 'AU' ? 'selected' : '' }}>Australia</option>
                                        <option value="IN" {{ old('country', $client->country) == 'IN' ? 'selected' : '' }}>India</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes about the client...">{{ old('notes', $client->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Sidebar -->
            <div class="col-lg-4">
                <!-- Notification Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="mb-0">
                            <i class="fa fa-bell me-2"></i>Appointment Notifications
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Choose how this client is notified about appointments</p>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="email_notifications" 
                                   name="email_notifications" value="1" 
                                   {{ old('email_notifications', $client->email_notifications) ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_notifications">Email notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="text_message_notifications" 
                                   name="text_message_notifications" value="1" 
                                   {{ old('text_message_notifications', $client->text_message_notifications) ? 'checked' : '' }}>
                            <label class="form-check-label" for="text_message_notifications">Text message notifications</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="whatsapp_notifications" 
                                   name="whatsapp_notifications" value="1" 
                                   {{ old('whatsapp_notifications', $client->whatsapp_notifications) ? 'checked' : '' }}>
                            <label class="form-check-label" for="whatsapp_notifications">WhatsApp notifications</label>
                        </div>
                    </div>
                </div>

                <!-- Marketing Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0">
                            <i class="fa fa-bullhorn me-2"></i>Marketing Notifications
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Choose if this client has agreed to receive marketing notifications</p>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="email_marketing" 
                                   name="email_marketing" value="1" 
                                   {{ old('email_marketing', $client->email_marketing) ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_marketing">Email marketing</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="text_message_marketing" 
                                   name="text_message_marketing" value="1" 
                                   {{ old('text_message_marketing', $client->text_message_marketing) ? 'checked' : '' }}>
                            <label class="form-check-label" for="text_message_marketing">Text message marketing</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="whatsapp_marketing" 
                                   name="whatsapp_marketing" value="1" 
                                   {{ old('whatsapp_marketing', $client->whatsapp_marketing) ? 'checked' : '' }}>
                            <label class="form-check-label" for="whatsapp_marketing">WhatsApp marketing</label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fa fa-save me-2"></i>Update Client
                            </button>
                            <a href="{{ route('store.clients.show', $client) }}" class="btn btn-outline-secondary">
                                <i class="fa fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    border-radius: 0.5rem;
}

.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('clientForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                valid = false;
                field.classList.add('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endpush