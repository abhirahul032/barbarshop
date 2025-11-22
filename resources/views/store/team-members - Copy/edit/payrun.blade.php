<!-- resources/views/team-members/partials/payrun.blade.php -->

<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Pay runs</h5>
        <small class="text-muted">Choose how you will pay this team member through pay runs. <a href="#">Learn more</a></small>
    </div>
    <div class="section-body">
        <!-- Preferred Payment Method -->
        <div class="mb-4">
            <h6>Preferred payment method</h6>
            <p class="text-muted">Choose how you would prefer to pay your team member when completing a pay run. A processing fee may apply for transfers to bank accounts. <a href="#">Learn more</a></p>
            <select class="form-select" id="preferred_payment_method" name="preferred_payment_method">
                <option value="manual" {{ ($payRun->preferred_payment_method ?? 'manual') === 'manual' ? 'selected' : '' }}>Pay manually</option>
                <option value="bank_transfer" {{ ($payRun->preferred_payment_method ?? 'manual') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="cash" {{ ($payRun->preferred_payment_method ?? 'manual') === 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="check" {{ ($payRun->preferred_payment_method ?? 'manual') === 'check' ? 'selected' : '' }}>Check</option>
            </select>
            <small class="text-muted mt-2 d-block">Mark as paid outside of Fresha</small>
        </div>

        <!-- Calculation of Pay Runs -->
        <div class="mb-4">
            <h6>Calculation of pay runs</h6>
            <p class="text-muted">Choose if the amount to pay is calculated automatically or manually entered at each pay period</p>
            
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pay_calculation" id="automatic_calculation" value="automatic"
                    {{ ($payRun->pay_calculation ?? 'automatic') === 'automatic' ? 'checked' : '' }}>
                <label class="form-check-label" for="automatic_calculation">
                    Automatic calculation<br>
                    <small class="text-muted">Calculates the amount to pay based on activity from timesheets, earned wages, commissions and tips as configured on this team member's settings.</small>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pay_calculation" id="manual_calculation" value="manual"
                    {{ ($payRun->pay_calculation ?? 'automatic') === 'manual' ? 'checked' : '' }}>
                <label class="form-check-label" for="manual_calculation">
                    Manual calculation<br>
                    <small class="text-muted">Manually enter the amount to pay at each pay period.</small>
                </label>
            </div>
        </div>

        <!-- Pay Run Schedule -->
        <div class="mb-4">
            <h6>Pay run schedule</h6>
            <p class="text-muted">Set up how often this team member gets paid</p>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="pay_frequency" class="form-label">Pay frequency</label>
                    <select class="form-select" id="pay_frequency" name="pay_frequency">
                        <option value="weekly" {{ ($payRun->pay_frequency ?? 'weekly') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="bi_weekly" {{ ($payRun->pay_frequency ?? 'weekly') === 'bi_weekly' ? 'selected' : '' }}>Bi-weekly</option>
                        <option value="semi_monthly" {{ ($payRun->pay_frequency ?? 'weekly') === 'semi_monthly' ? 'selected' : '' }}>Semi-monthly</option>
                        <option value="monthly" {{ ($payRun->pay_frequency ?? 'weekly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="next_pay_date" class="form-label">Next pay date</label>
                    <input type="date" class="form-control" id="next_pay_date" name="next_pay_date" 
                           value="{{ $payRun->next_pay_date ?? '' }}">
                </div>
            </div>
        </div>

        <!-- Pay Run Deductions -->
        <div class="mb-4">
            <h6>Pay run deductions</h6>
            <p class="text-muted">Choose which fees to automatically deduct from this team member's earnings. <a href="#">Learn more</a></p>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="deduct_processing_fees" name="deduct_processing_fees" value="1"
                    {{ ($payRun->deduct_processing_fees ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="deduct_processing_fees">
                    Deduct Fresha payment processing fees<br>
                    <small class="text-muted">Deduct payment processing fees for items sold by this team member.</small>
                </label>
            </div>

            <div id="processing_fee_fields" style="display: {{ ($payRun->deduct_processing_fees ?? false) ? 'block' : 'none' }}; margin-left: 20px;">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="processing_fee_percentage" class="form-label">Portion of fee</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="processing_fee_percentage" 
                                   name="processing_fee_percentage" value="{{ $payRun->processing_fee_percentage ?? 100 }}" 
                                   min="0" max="100" step="1">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <small class="text-muted">
                            {{ $payRun->processing_fee_percentage ?? 100 }}% of the fee amount will be deducted
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="deduct_client_fees" name="deduct_client_fees" value="1"
                    {{ ($payRun->deduct_client_fees ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="deduct_client_fees">
                    Deduct Fresha new client fees<br>
                    <small class="text-muted">Deduct the new client fee for any new client bookings with this team member.</small>
                </label>
            </div>

            <div id="client_fee_fields" style="display: {{ ($payRun->deduct_client_fees ?? false) ? 'block' : 'none' }}; margin-left: 20px;">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="client_fee_percentage" class="form-label">Portion of fee</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="client_fee_percentage" 
                                   name="client_fee_percentage" value="{{ $payRun->client_fee_percentage ?? 100 }}" 
                                   min="0" max="100" step="1">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <small class="text-muted">
                            {{ $payRun->client_fee_percentage ?? 100 }}% of the fee amount will be deducted
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Settings -->
        <div class="mb-4">
            <h6>Additional settings</h6>
            
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="include_commissions" name="include_commissions" value="1"
                    {{ ($payRun->include_commissions ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="include_commissions">
                    Include commissions in pay runs
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="include_tips" name="include_tips" value="1"
                    {{ ($payRun->include_tips ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="include_tips">
                    Include tips in pay runs
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="include_bonuses" name="include_bonuses" value="1"
                    {{ ($payRun->include_bonuses ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="include_bonuses">
                    Include bonuses in pay runs
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="auto_generate_pay_runs" name="auto_generate_pay_runs" value="1"
                    {{ ($payRun->auto_generate_pay_runs ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="auto_generate_pay_runs">
                    Automatically generate pay runs
                </label>
            </div>
        </div>

        <!-- Cash Advances -->
        <div class="mb-4">
            <h6>Cash advances</h6>
            <p class="text-muted">Choose how you want to manage cash payments</p>
            
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="record_cash_advances" name="record_cash_advances" value="1"
                    {{ ($payRun->record_cash_advances ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="record_cash_advances">
                    Record cash payments for sales as 'paid' in pay runs<br>
                    <small class="text-muted">When a sale is paid in cash, record that this team member has taken the full cash amount as an advance within the pay period.</small>
                </label>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end">
            <button type="button" id="savePayRunBtn" class="btn btn-primary">
                <i class="fas fa-spinner fa-spin d-none"></i>
                Save Pay Run Settings
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle deduction fields
    function toggleDeductionFields(checkboxId, fieldsId) {
        const checkbox = document.getElementById(checkboxId);
        const fields = document.getElementById(fieldsId);
        
        if (checkbox && fields) {
            fields.style.display = checkbox.checked ? 'block' : 'none';
            
            checkbox.addEventListener('change', function() {
                fields.style.display = this.checked ? 'block' : 'none';
            });
        }
    }

    // Update percentage text in real-time
    function setupPercentageUpdate(inputId, textElement) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', function() {
                const percentageText = document.querySelector(textElement);
                if (percentageText) {
                    percentageText.textContent = `${this.value}% of the fee amount will be deducted`;
                }
            });
        }
    }

    // Initialize deduction toggles
    toggleDeductionFields('deduct_processing_fees', 'processing_fee_fields');
    toggleDeductionFields('deduct_client_fees', 'client_fee_fields');

    // Initialize percentage updates
    setupPercentageUpdate('processing_fee_percentage', '.text-muted:has(+ #client_fee_fields)');
    setupPercentageUpdate('client_fee_percentage', '#client_fee_fields .text-muted');

    // AJAX form submission
    document.getElementById('savePayRunBtn').addEventListener('click', function() {
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
        
        // Add all pay run fields
        const payRunFields = [
            'preferred_payment_method', 'pay_calculation', 'pay_frequency', 'next_pay_date',
            'deduct_processing_fees', 'deduct_client_fees', 'processing_fee_percentage', 'client_fee_percentage',
            'record_cash_advances', 'auto_record_cash_payments', 'include_commissions', 
            'include_tips', 'include_bonuses', 'auto_generate_pay_runs'
        ];

        payRunFields.forEach(field => {
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
        fetch('{{ route("store.team-members.payrun.store", $teamMember->id) }}', {
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
            btn.innerHTML = '<i class="fas fa-spinner fa-spin d-none"></i>Save Pay Run Settings';
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