{{-- resources/views/store/tax-rates/index.blade.php --}}
@extends('store.layouts.app')

@section('title', 'Tax Rates')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaxRateModal">
                        <i class="fa faplus me-1"></i> Add Tax Rate
                    </button>
                </div>
                <h4 class="page-title">Tax Rates</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Default</th>
                                    <th>Used In</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxRates as $taxRate)
                                <tr>
                                    <td>{{ $taxRate->name }}</td>
                                    <td>{{ $taxRate->rate }}%</td>
                                    <td>
                                        @if($taxRate->is_default)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>{{ $taxRate->memberships_count ?? 0 }} memberships</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTaxRateModal"
                                                    data-taxrate-id="{{ $taxRate->id }}"
                                                    data-taxrate-name="{{ $taxRate->name }}"
                                                    data-taxrate-rate="{{ $taxRate->rate }}"
                                                    data-taxrate-default="{{ $taxRate->is_default }}">
                                                <i class="fa faedit"></i>
                                            </button>
                                            @if(!$taxRate->is_default && (!$taxRate->memberships_count || $taxRate->memberships_count == 0))
                                            <form action="{{ route('store.tax-rates.destroy', $taxRate) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure?')">
                                                    <i class="fa fatrash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @if($taxRates->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fa fapercentage fa-2x text-muted mb-2"></i>
                                        <h5 class="text-muted">No Tax Rates</h5>
                                        <p class="text-muted">Add your first tax rate to use in memberships.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Tax Rate Modal -->
<div class="modal fade" id="createTaxRateModal" tabindex="-1" aria-labelledby="createTaxRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('store.tax-rates.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaxRateModalLabel">Add Tax Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tax Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate" class="form-label">Tax Rate (%) *</label>
                        <input type="number" class="form-control" id="rate" name="rate" 
                               step="0.01" min="0" max="100" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default">
                        <label class="form-check-label" for="is_default">
                            Set as default tax rate
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Tax Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Tax Rate Modal -->
<div class="modal fade" id="editTaxRateModal" tabindex="-1" aria-labelledby="editTaxRateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTaxRateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaxRateModalLabel">Edit Tax Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tax Name *</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_rate" class="form-label">Tax Rate (%) *</label>
                        <input type="number" class="form-control" id="edit_rate" name="rate" 
                               step="0.01" min="0" max="100" required>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="edit_is_default">
                        <label class="form-check-label" for="edit_is_default">
                            Set as default tax rate
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Tax Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Tax Rate Modal
    const editTaxRateModal = document.getElementById('editTaxRateModal');
    editTaxRateModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const taxRateId = button.getAttribute('data-taxrate-id');
        const taxRateName = button.getAttribute('data-taxrate-name');
        const taxRateRate = button.getAttribute('data-taxrate-rate');
        const taxRateDefault = button.getAttribute('data-taxrate-default') === '1';

        const form = document.getElementById('editTaxRateForm');
        form.action = `/store/tax-rates/${taxRateId}`;

        document.getElementById('edit_name').value = taxRateName;
        document.getElementById('edit_rate').value = taxRateRate;
        document.getElementById('edit_is_default').checked = taxRateDefault;
    });

    // Reset create modal when closed
    const createModal = document.getElementById('createTaxRateModal');
    createModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('name').value = '';
        document.getElementById('rate').value = '';
        document.getElementById('is_default').checked = false;
    });
});
</script>
@endpush