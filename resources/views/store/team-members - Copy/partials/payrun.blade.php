
<!-- Pay Runs Section -->
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
                <option value="manual">Pay manually</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="cash">Cash</option>
                <option value="check">Check</option>
            </select>
            <small class="text-muted mt-2 d-block">Mark as paid outside of Fresha</small>
        </div>

        <!-- Calculation of Pay Runs -->
        <div class="mb-4">
            <h6>Calculation of pay runs</h6>
            <p class="text-muted">Choose if the amount to pay is calculated automatically or manually entered at each pay period</p>
            
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pay_calculation" id="automatic_calculation" value="automatic" checked>
                <label class="form-check-label" for="automatic_calculation">
                    Automatic calculation<br>
                    <small class="text-muted">Calculates the amount to pay based on activity from timesheets, earned wages, commissions and tips as configured on this team member's settings.</small>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pay_calculation" id="manual_calculation" value="manual">
                <label class="form-check-label" for="manual_calculation">
                    Manual calculation<br>
                    <small class="text-muted">Manually enter the amount to pay at each pay period.</small>
                </label>
            </div>
        </div>

        <!-- Pay Run Deductions -->
        <div class="mb-4">
            <h6>Pay run deductions</h6>
            <p class="text-muted">Choose which fees to automatically deduct from this team member's earnings. <a href="#">Learn more</a></p>
            
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="deduct_processing_fees" name="deduct_processing_fees">
                <label class="form-check-label" for="deduct_processing_fees">
                    Deduct Fresha payment processing fees<br>
                    <small class="text-muted">Deduct payment processing fees for items sold by this team member.</small>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="deduct_client_fees" name="deduct_client_fees">
                <label class="form-check-label" for="deduct_client_fees">
                    Deduct Fresha new client fees<br>
                    <small class="text-muted">Deduct the new client fee for any new client bookings with this team member.</small>
                </label>
            </div>
        </div>

        <!-- Cash Advances -->
        <div class="mb-4">
            <h6>Cash advances</h6>
            <p class="text-muted">Choose how you want to manage cash payments</p>
            
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="record_cash_advances" name="record_cash_advances">
                <label class="form-check-label" for="record_cash_advances">
                    Record cash payments for sales as 'paid' in pay runs<br>
                    <small class="text-muted">When a sale is paid in cash, record that this team member has taken the full cash amount as an advance within the pay period.</small>
                </label>
            </div>
        </div>
    </div>
</div>