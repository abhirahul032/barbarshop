@extends('store.layouts.app')

@section('title', 'Daily Sales')

@section('content')

<style>
     .page-header {
            background: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .date-selector {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .date-selector .btn {
            padding: 0.25rem 0.5rem;
            border: none;
            background: transparent;
        }
        
        .date-selector .btn:hover {
            background: #f8f9fa;
            border-radius: 4px;
        }
        
        .date-text {
            font-weight: 500;
            color: #212529;
        }
        
        .summary-card {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .summary-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #212529;
        }
        
        .summary-table {
            width: 100%;
            margin: 0;
        }
        
        .summary-table thead th {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            border-bottom: 2px solid #e9ecef;
            padding: 0.75rem 0.5rem;
            text-align: left;
        }
        
        .summary-table tbody td {
            padding: 0.85rem 0.5rem;
            border-bottom: 1px solid #f1f3f5;
            font-size: 0.95rem;
            color: #212529;
        }
        
        .summary-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .summary-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .text-end {
            text-align: right;
        }
        
        .btn-export {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            font-weight: 500;
            margin-right: 0.5rem;
        }
        
        .btn-export:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .btn-add-new {
            background: #000;
            border: 1px solid #000;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
        }
        
        .btn-add-new:hover {
            background: #212529;
            border-color: #212529;
            color: white;
        }
        
        .total-row {
            font-weight: 600;
            background-color: #f8f9fa !important;
        }
        
        .currency {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Daily Sales</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Daily Sales</li>
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
         <div class="container">
        <!-- Date Selector -->
        <div class="date-selector">
            <button class="btn btn-sm">
                <i class="bi bi-chevron-left"></i>
            </button>
            <span class="date-text">Today</span>
            <span class="text-muted">Monday 17 Nov, 2025</span>
            <button class="btn btn-sm">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

        <!-- Summary Cards Row -->
        <div class="row">
            <!-- Transaction Summary -->
            <div class="col-lg-6">
                <div class="summary-card">
                    <h2 class="summary-title">Transaction summary</h2>
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th>Item type</th>
                                <th class="text-end">Sales qty</th>
                                <th class="text-end">Refund qty</th>
                                <th class="text-end">Gross total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Services</td>
                                <td class="text-end">18</td>
                                <td class="text-end">1</td>
                                <td class="text-end currency">?12,450.00</td>
                            </tr>
                            <tr>
                                <td>Service add-ons</td>
                                <td class="text-end">5</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?1,200.00</td>
                            </tr>
                            <tr>
                                <td>Products</td>
                                <td class="text-end">7</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?3,850.00</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td class="text-end">2</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?150.00</td>
                            </tr>
                            <tr>
                                <td>Gift cards</td>
                                <td class="text-end">3</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?5,000.00</td>
                            </tr>
                            <tr>
                                <td>Memberships</td>
                                <td class="text-end">2</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?8,000.00</td>
                            </tr>
                            <tr>
                                <td>Late cancellation fees</td>
                                <td class="text-end">1</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?500.00</td>
                            </tr>
                            <tr>
                                <td>No-show fees</td>
                                <td class="text-end">0</td>
                                <td class="text-end">0</td>
                                <td class="text-end currency">?0.00</td>
                            </tr>
                            <tr class="total-row">
                                <td><strong>Total</strong></td>
                                <td class="text-end"><strong>38</strong></td>
                                <td class="text-end"><strong>1</strong></td>
                                <td class="text-end currency"><strong>?31,150.00</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cash Movement Summary -->
            <div class="col-lg-6">
                <div class="summary-card">
                    <h2 class="summary-title">Cash movement summary</h2>
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th>Payment type</th>
                                <th class="text-end">Payments collected</th>
                                <th class="text-end">Refunds paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash</td>
                                <td class="text-end currency">?14,250.00</td>
                                <td class="text-end currency">?550.00</td>
                            </tr>
                            <tr>
                                <td>Other</td>
                                <td class="text-end currency">?16,900.00</td>
                                <td class="text-end currency">?0.00</td>
                            </tr>
                            <tr>
                                <td>Gift card redemptions</td>
                                <td class="text-end currency">?1,200.00</td>
                                <td class="text-end currency">?0.00</td>
                            </tr>
                            <tr class="total-row">
                                <td><strong>Payments collected</strong></td>
                                <td class="text-end currency"><strong>?32,350.00</strong></td>
                                <td class="text-end currency"><strong>?550.00</strong></td>
                            </tr>
                            <tr>
                                <td>Of which tips</td>
                                <td class="text-end currency">?1,200.00</td>
                                <td class="text-end currency">?0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Additional Details Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="summary-card">
                    <h2 class="summary-title">Today's Transactions Details</h2>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Reference</th>
                                    <th>Client</th>
                                    <th>Service/Product</th>
                                    <th>Staff</th>
                                    <th class="text-end">Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10:00 AM</td>
                                    <td><span class="badge bg-light text-dark">BK001</span></td>
                                    <td>Rahul Sharma</td>
                                    <td>Hair Cut</td>
                                    <td>Neha Verma</td>
                                    <td class="text-end currency">?550.00</td>
                                    <td>Cash</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>10:30 AM</td>
                                    <td><span class="badge bg-light text-dark">BK002</span></td>
                                    <td>Priya Patel</td>
                                    <td>Hair Coloring</td>
                                    <td>Pooja Shah</td>
                                    <td class="text-end currency">?2,500.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>11:15 AM</td>
                                    <td><span class="badge bg-light text-dark">BK003</span></td>
                                    <td>Amit Kumar</td>
                                    <td>Facial Treatment + Massage</td>
                                    <td>Meera Desai</td>
                                    <td class="text-end currency">?3,500.00</td>
                                    <td>Cash</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-light text-dark">BK004</span></td>
                                    <td>Sneha Reddy</td>
                                    <td>Swedish Massage</td>
                                    <td>Kavita Iyer</td>
                                    <td class="text-end currency">?2,200.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>01:00 PM</td>
                                    <td><span class="badge bg-light text-dark">PROD05</span></td>
                                    <td>Anjali Mehta</td>
                                    <td>Hair Care Products (3 items)</td>
                                    <td>-</td>
                                    <td class="text-end currency">?1,850.00</td>
                                    <td>Cash</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>02:00 PM</td>
                                    <td><span class="badge bg-light text-dark">BK006</span></td>
                                    <td>Vikram Singh</td>
                                    <td>Hot Stone Massage</td>
                                    <td>Kavita Iyer</td>
                                    <td class="text-end currency">?2,800.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>02:45 PM</td>
                                    <td><span class="badge bg-light text-dark">GC001</span></td>
                                    <td>Rohan Deshmukh</td>
                                    <td>Gift Card - ?2,000</td>
                                    <td>-</td>
                                    <td class="text-end currency">?2,000.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>03:15 PM</td>
                                    <td><span class="badge bg-light text-dark">BK007</span></td>
                                    <td>Deepa Nair</td>
                                    <td>Manicure + Pedicure</td>
                                    <td>Meera Desai</td>
                                    <td class="text-end currency">?1,200.00</td>
                                    <td>Gift Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>04:00 PM</td>
                                    <td><span class="badge bg-light text-dark">MEM01</span></td>
                                    <td>Karthik Rao</td>
                                    <td>Premium Membership (6 months)</td>
                                    <td>-</td>
                                    <td class="text-end currency">?5,000.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>04:30 PM</td>
                                    <td><span class="badge bg-light text-dark">BK008</span></td>
                                    <td>Nisha Gupta</td>
                                    <td>Blow Dry + Styling</td>
                                    <td>Neha Verma</td>
                                    <td class="text-end currency">?1,100.00</td>
                                    <td>Cash</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>05:00 PM</td>
                                    <td><span class="badge bg-light text-dark">REF001</span></td>
                                    <td>Aditya Joshi</td>
                                    <td>Hair Cut (Refund)</td>
                                    <td>Ramesh Kumar</td>
                                    <td class="text-end currency text-danger">-?550.00</td>
                                    <td>Cash</td>
                                    <td><span class="badge bg-danger">Refunded</span></td>
                                </tr>
                                <tr>
                                    <td>05:30 PM</td>
                                    <td><span class="badge bg-light text-dark">BK009</span></td>
                                    <td>Sanjana Iyer</td>
                                    <td>Spa Package</td>
                                    <td>Kavita Iyer</td>
                                    <td class="text-end currency">?4,500.00</td>
                                    <td>Card</td>
                                    <td><span class="badge bg-warning text-dark">In Progress</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats Cards -->
        <div class="row mt-4 mb-5">
            <div class="col-md-3">
                <div class="summary-card text-center">
                    <div class="text-muted mb-2">Total Revenue</div>
                    <h3 class="text-success mb-0 currency">?31,150.00</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card text-center">
                    <div class="text-muted mb-2">Total Transactions</div>
                    <h3 class="text-primary mb-0">38</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card text-center">
                    <div class="text-muted mb-2">Average Transaction</div>
                    <h3 class="text-info mb-0 currency">?819.74</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card text-center">
                    <div class="text-muted mb-2">Tips Collected</div>
                    <h3 class="text-warning mb-0 currency">?1,200.00</h3>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection