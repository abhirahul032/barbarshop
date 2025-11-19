
<!-- Commissions Section -->
<div class="card section-card">
    <div class="section-header">
        <h5 class="mb-0">Commissions</h5>
    </div>
    <div class="section-body">
        <!-- Services Commission -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Services commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="services_commission" name="services_commission" checked>
                </div>
            </div>
            <p class="text-muted">Commission earned on services provided. <a href="#">Learn more</a></p>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="default_commission_type" class="form-label">Default commission type</label>
                    <select class="form-select" id="default_commission_type" name="default_commission_type">
                        <option value="fixed_rate">Fixed rate</option>
                        <option value="percentage">Percentage</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="default_rate" class="form-label">Default rate</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="default_rate" name="default_rate" value="0" step="0.01">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h6>Customize commissions by service</h6>
                <p class="text-muted">{{ $services->count() }} services on default rate</p>
            </div>

            <div class="mb-3">
                <h6>Calculations</h6>
                <p class="text-muted">Customize deductions for this team member. <a href="#">Learn more</a></p>
                
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="commission_calculation" id="default_settings" value="default" checked>
                    <label class="form-check-label" for="default_settings">
                        Default settings<br>
                        <small class="text-muted">Use your workspace commission settings</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="commission_calculation" id="custom_settings" value="custom">
                    <label class="form-check-label" for="custom_settings">
                        Custom settings<br>
                        <small class="text-muted">Choose custom settings for this team member</small>
                    </label>
                </div>
            </div>
        </div>

        <!-- Products Commission -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Products commission</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="products_commission" name="products_commission">
                </div>
            </div>
            <p class="text-muted">Commission earned on products sold. <a href="#">Learn more</a></p>
            
            <!-- Similar structure as services commission -->
        </div>

        <!-- Gift Cards Commission -->
        <div class="mb-4">
            <h6>Gift cards commission</h6>
            <p class="text-muted">Commission earned on gift cards sold. <a href="#">Learn more</a></p>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Default commission type</th>
                            <th>Default rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fixed rate</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">?</span>
                                    <input type="number" class="form-control" value="0" step="0.01">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Memberships Commission -->
        <div class="mb-4">
            <h6>Memberships commission</h6>
            <p class="text-muted">Commission earned on memberships sold. <a href="#">Learn more</a></p>
            
            <!-- Similar structure as gift cards commission -->
        </div>

        <!-- Cancellation Commission -->
        <div class="mb-4">
            <h6>Cancellation commission</h6>
            <p class="text-muted">Commission earned on fees for no-shows and late cancellations. <a href="#">Learn more</a></p>
            
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="late_cancellation_fee" name="late_cancellation_fee">
                <label class="form-check-label" for="late_cancellation_fee">
                    Pass on the cancellation fee for late cancellations<br>
                    <small class="text-muted">When the client cancels late, the team member earns a portion of the cancellation fee</small>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="no_show_fee" name="no_show_fee">
                <label class="form-check-label" for="no_show_fee">
                    Pass on the cancellation fee for no-shows<br>
                    <small class="text-muted">When the client is a no-show, the team member earns a portion of the fee</small>
                </label>
            </div>
        </div>
    </div>
</div>