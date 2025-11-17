@extends('store.layouts.app')

@section('title', 'Appointments List')

@section('content')

<style>
       
        
        .page-header {
            background: white;
            padding: 2rem 0 1rem;
            margin-bottom: 2rem;
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
            margin-bottom: 1.5rem;
        }
        
        .search-bar {
            position: relative;
            max-width: 300px;
        }
        
        .search-bar input {
            padding-left: 2.5rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
        }
        
        .search-bar .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .filter-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: #212529;
            font-weight: 500;
            margin-right: 0.5rem;
        }
        
        .filter-btn:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .btn-export {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-export:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .table-container {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .appointments-table {
            margin: 0;
            font-size: 0.9rem;
        }
        
        .appointments-table thead th {
            background: #fafbfc;
            border-bottom: 1px solid #e9ecef;
            color: #212529;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 1rem 0.75rem;
            white-space: nowrap;
        }
        
        .appointments-table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
            color: #212529;
        }
        
        .appointments-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .appointments-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .ref-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
        
        .ref-link:hover {
            text-decoration: underline;
        }
        
        .badge-booked {
            background-color: #e7f3ff;
            color: #0066cc;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-completed {
            background-color: #e6f7ed;
            color: #0d894f;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-cancelled {
            background-color: #fee;
            color: #c41e3a;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .results-info {
            text-align: center;
            padding: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .client-name {
            color: #212529;
            font-weight: 500;
        }
        
        .text-muted-custom {
            color: #6c757d;
        }
        
        .sort-dropdown {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            min-width: 220px;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Appointments List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Appointments List</li>
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
         <div class="page-header">
        <div class="container-fluid px-4">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                    <h1 class="page-title">Appointments</h1>
                    <p class="page-subtitle">View, filter and export appointments booked by your clients.</p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-export dropdown-toggle">
                        Export
                    </button>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="row align-items-center mb-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-2">
                        <div class="search-bar">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" placeholder="Search by Reference or Client">
                        </div>
                        <button class="filter-btn">
                            <i class="bi bi-calendar3"></i>
                            Month to date
                        </button>
                        <button class="filter-btn">
                            <i class="bi bi-funnel"></i>
                            Filters
                        </button>
                    </div>
                </div>
                <div class="col-md-5 text-end">
                    <select class="form-select sort-dropdown d-inline-block">
                        <option selected>Scheduled Date (newest first)</option>
                        <option value="oldest">Scheduled Date (oldest first)</option>
                        <option value="price-high">Price (high to low)</option>
                        <option value="price-low">Price (low to high)</option>
                        <option value="client">Client Name (A-Z)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table appointments-table">
                    <thead>
                        <tr>
                            <th>Ref #</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Created by</th>
                            <th>Created Date <i class="bi bi-chevron-down"></i></th>
                            <th>Scheduled Date <i class="bi bi-chevron-down"></i></th>
                            <th>Duration <i class="bi bi-chevron-down"></i></th>
                            <th>Team member</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#" class="ref-link">#425b43E2</a></td>
                            <td><span class="client-name">Walk-In</span></td>
                            <td>Haircut</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                15 Nov 2025,<br>
                                9:41am
                            </td>
                            <td>
                                17 Nov 2025,<br>
                                11:15am
                            </td>
                            <td>45min</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td>?40.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#619f3D36</a></td>
                            <td><span class="client-name">Walk-In</span></td>
                            <td>Haircut</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                15 Nov 2025,<br>
                                9:41am
                            </td>
                            <td>
                                17 Nov 2025,<br>
                                10:30am
                            </td>
                            <td>45min</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td>?40.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#C0F6547D</a></td>
                            <td><span class="client-name">Jane Doe</span></td>
                            <td>Hair Color</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                15 Nov 2025,<br>
                                8:58am
                            </td>
                            <td>
                                15 Nov 2025,<br>
                                1:00pm
                            </td>
                            <td>1h 15min</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td>?57.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#3FA7B488</a></td>
                            <td><span class="client-name">John Doe</span></td>
                            <td>Haircut</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                15 Nov 2025,<br>
                                8:58am
                            </td>
                            <td>
                                15 Nov 2025,<br>
                                11:00am
                            </td>
                            <td>45min</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td>?40.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#80B8C4E5</a></td>
                            <td><span class="client-name">Jack Doe</span></td>
                            <td>Blow Dry</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                15 Nov 2025,<br>
                                8:59am
                            </td>
                            <td>
                                15 Nov 2025,<br>
                                10:00am
                            </td>
                            <td>35min</td>
                            <td class="text-muted-custom">Wendy Smith<br>(Demo)</td>
                            <td>?35.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#9F2D1B67</a></td>
                            <td><span class="client-name">Priya Patel</span></td>
                            <td>Hair Coloring</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                14 Nov 2025,<br>
                                2:15pm
                            </td>
                            <td>
                                16 Nov 2025,<br>
                                11:00am
                            </td>
                            <td>2h 0min</td>
                            <td class="text-muted-custom">Pooja Shah</td>
                            <td>?2,500.00</td>
                            <td><span class="badge-booked">Booked</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#7C8E3A92</a></td>
                            <td><span class="client-name">Amit Kumar</span></td>
                            <td>Facial Treatment</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                14 Nov 2025,<br>
                                10:30am
                            </td>
                            <td>
                                16 Nov 2025,<br>
                                3:00pm
                            </td>
                            <td>1h 0min</td>
                            <td class="text-muted-custom">Meera Desai</td>
                            <td>?1,300.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#4B5F8D21</a></td>
                            <td><span class="client-name">Sneha Reddy</span></td>
                            <td>Swedish Massage</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                13 Nov 2025,<br>
                                5:45pm
                            </td>
                            <td>
                                15 Nov 2025,<br>
                                10:00am
                            </td>
                            <td>1h 30min</td>
                            <td class="text-muted-custom">Kavita Iyer</td>
                            <td>?2,200.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#2E9A6F33</a></td>
                            <td><span class="client-name">Vikram Singh</span></td>
                            <td>Hot Stone Massage</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                13 Nov 2025,<br>
                                11:20am
                            </td>
                            <td>
                                15 Nov 2025,<br>
                                2:00pm
                            </td>
                            <td>2h 0min</td>
                            <td class="text-muted-custom">Kavita Iyer</td>
                            <td>?2,800.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#5D7C2E98</a></td>
                            <td><span class="client-name">Anjali Mehta</span></td>
                            <td>Manicure</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                12 Nov 2025,<br>
                                9:15am
                            </td>
                            <td>
                                14 Nov 2025,<br>
                                4:00pm
                            </td>
                            <td>45min</td>
                            <td class="text-muted-custom">Meera Desai</td>
                            <td>?600.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#8A3F5B77</a></td>
                            <td><span class="client-name">Rohan Deshmukh</span></td>
                            <td>Beard Trim</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                11 Nov 2025,<br>
                                3:30pm
                            </td>
                            <td>
                                13 Nov 2025,<br>
                                9:30am
                            </td>
                            <td>30min</td>
                            <td class="text-muted-custom">Ramesh Kumar</td>
                            <td>?300.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#6E1D9C44</a></td>
                            <td><span class="client-name">Deepa Nair</span></td>
                            <td>Pedicure</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                10 Nov 2025,<br>
                                1:20pm
                            </td>
                            <td>
                                12 Nov 2025,<br>
                                11:00am
                            </td>
                            <td>1h 0min</td>
                            <td class="text-muted-custom">Meera Desai</td>
                            <td>?800.00</td>
                            <td><span class="badge-cancelled">Cancelled</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#3C8B4F29</a></td>
                            <td><span class="client-name">Karthik Rao</span></td>
                            <td>Hair Spa</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                10 Nov 2025,<br>
                                10:15am
                            </td>
                            <td>
                                12 Nov 2025,<br>
                                2:30pm
                            </td>
                            <td>1h 30min</td>
                            <td class="text-muted-custom">Neha Verma</td>
                            <td>?1,800.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#9B2E7A55</a></td>
                            <td><span class="client-name">Nisha Gupta</span></td>
                            <td>Blow Dry + Styling</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                9 Nov 2025,<br>
                                4:45pm
                            </td>
                            <td>
                                11 Nov 2025,<br>
                                5:00pm
                            </td>
                            <td>1h 15min</td>
                            <td class="text-muted-custom">Neha Verma</td>
                            <td>?1,100.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="ref-link">#4F6A3D88</a></td>
                            <td><span class="client-name">Sanjana Iyer</span></td>
                            <td>Spa Package</td>
                            <td class="text-muted-custom">RAHUL SHARMA</td>
                            <td class="text-muted-custom">
                                9 Nov 2025,<br>
                                11:30am
                            </td>
                            <td>
                                11 Nov 2025,<br>
                                10:00am
                            </td>
                            <td>3h 0min</td>
                            <td class="text-muted-custom">Kavita Iyer</td>
                            <td>?4,500.00</td>
                            <td><span class="badge-completed">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="results-info">
                Showing 15 of 15 results
            </div>
        </div>
    </div>
    </div>
</div>

@endsection