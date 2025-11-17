@extends('store.layouts.app')

@section('title', 'Payrun')

@section('content')
 <style>
       
        
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #212529;
            margin: 0 0 0.5rem 0;
        }
        
        .page-description {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .page-description a {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
        
        .page-description a:hover {
            text-decoration: underline;
        }
        
        .btn-options {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-options:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .filter-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        
        .date-selector {
            background: white;
            border: 1px solid #dee2e6;
            padding: 0.625rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #212529;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            min-width: 240px;
        }
        
        .date-selector:hover {
            background: #f8f9fa;
        }
        
        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr) auto;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .summary-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .summary-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .summary-value {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
        }
        
        .btn-pay-team {
            background: #212529;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            align-self: center;
        }
        
        .btn-pay-team:hover {
            background: #000;
            color: white;
        }
        
        .employee-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .employee-row {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: 280px repeat(5, 1fr);
            align-items: center;
            gap: 1.5rem;
            position: relative;
        }
        
        .employee-info {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }
        
        .employee-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .employee-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .employee-details {
            flex: 1;
        }
        
        .employee-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        
        .employee-actions {
            color: #6366f1;
            font-size: 0.875rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }
        
        .employee-actions:hover {
            text-decoration: underline;
        }
        
        .actions-dropdown {
            position: absolute;
            top: 4.5rem;
            left: 4.5rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 200px;
            display: none;
        }
        
        .actions-dropdown.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 0.875rem 1.25rem;
            color: #212529;
            text-decoration: none;
            display: block;
            font-size: 0.95rem;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        
        .dropdown-item:hover {
            background: #f8f9fa;
        }
        
        .dropdown-item:first-child {
            border-radius: 10px 10px 0 0;
        }
        
        .dropdown-item:last-child {
            border-radius: 0 0 10px 10px;
        }
        
        .pay-column {
            text-align: center;
        }
        
        .pay-label {
            color: #6b7280;
            font-size: 0.75rem;
            margin-bottom: 0.375rem;
        }
        
        .pay-value {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
        }
        
        .avatar-rahul {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
        }
        
        .avatar-wendy {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
        }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .btn-pay-team {
                grid-column: span 3;
                justify-self: center;
            }
            
            .employee-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .pay-column {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: left;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Payrun</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Payrun</li>
                </ol>
            </div>

        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="page-container">
        <div class="page-header">
            <div class="header-top">
                <div>
                    <h1 class="page-title">Pay runs</h1>
                    <p class="page-description">
                        Calculate and settle the amount owed to your team for tips, commissions, and wages. <a href="#">Learn more</a>
                    </p>
                </div>
                <button class="btn btn-options">
                    Options
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
        </div>

        <div class="filter-section">
            <div class="date-selector">
                <span>17 Nov 2025 - 23 Nov 2025</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search by name">
            </div>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-label">Earnings</div>
                <div class="summary-value">?0.00</div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">Other</div>
                <div class="summary-value">?0.00</div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">Total</div>
                <div class="summary-value">?0.00</div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">Paid</div>
                <div class="summary-value">?0.00</div>
            </div>
            
            <div class="summary-card">
                <div class="summary-label">To pay</div>
                <div class="summary-value">?0.00</div>
            </div>
            
            <button class="btn btn-pay-team">Pay team</button>
        </div>

        <div class="employee-list">
            <div class="employee-row" id="employee-row-1">
                <div class="employee-info">
                    <div class="employee-avatar avatar-rahul">
                        RS
                    </div>
                    <div class="employee-details">
                        <div class="employee-name">RAHUL SHARMA</div>
                        <button class="employee-actions" onclick="toggleDropdown(1)">
                            Actions
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Earnings</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Other</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Total</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Paid</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">To pay</div>
                    <div class="pay-value">?0.00</div>
                </div>

                <div class="actions-dropdown" id="dropdown-1">
                    <button class="dropdown-item">View breakdown</button>
                    <button class="dropdown-item">Edit team member</button>
                    <button class="dropdown-item">Add adjustment</button>
                </div>
            </div>

            <div class="employee-row" id="employee-row-2">
                <div class="employee-info">
                    <div class="employee-avatar avatar-wendy">
                        WS
                    </div>
                    <div class="employee-details">
                        <div class="employee-name">Wendy Smith (Demo)</div>
                        <button class="employee-actions" onclick="toggleDropdown(2)">
                            Actions
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Earnings</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Other</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Total</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">Paid</div>
                    <div class="pay-value">?0.00</div>
                </div>
                
                <div class="pay-column">
                    <div class="pay-label">To pay</div>
                    <div class="pay-value">?0.00</div>
                </div>

                <div class="actions-dropdown" id="dropdown-2">
                    <button class="dropdown-item">View breakdown</button>
                    <button class="dropdown-item">Edit team member</button>
                    <button class="dropdown-item">Add adjustment</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
 <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(`dropdown-${id}`);
            const allDropdowns = document.querySelectorAll('.actions-dropdown');
            
            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== `dropdown-${id}`) {
                    dd.classList.remove('show');
                }
            });
            
            // Toggle the clicked dropdown
            dropdown.classList.toggle('show');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideDropdown = event.target.closest('.employee-actions') || event.target.closest('.actions-dropdown');
            
            if (!isClickInsideDropdown) {
                document.querySelectorAll('.actions-dropdown').forEach(dd => {
                    dd.classList.remove('show');
                });
            }
        });
        
        // Add click handlers for dropdown items
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const action = this.textContent;
                alert(`Action clicked: ${action}`);
                // Close the dropdown
                this.closest('.actions-dropdown').classList.remove('show');
            });
        });
    </script>
@endsection