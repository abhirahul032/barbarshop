@extends('store.layouts.app')

@section('title', 'Client List')

@section('content')
<style>
        
        
        .page-header {
            background: white;
            padding: 2rem 0 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .page-title .badge {
            font-size: 0.875rem;
            font-weight: 500;
            background: #e9ecef;
            color: #6c757d;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-left: 0.5rem;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .page-subtitle a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .page-subtitle a:hover {
            text-decoration: underline;
        }
        
        .btn-options {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            margin-right: 0.5rem;
        }
        
        .btn-options:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .btn-add {
            background: #212529;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
        }
        
        .btn-add:hover {
            background: #000;
            color: white;
        }
        
        .promo-banner {
            background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
            border-radius: 12px;
            padding: 2rem;
            margin: 1.5rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .promo-content {
            max-width: 60%;
        }
        
        .promo-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .promo-description {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }
        
        .btn-learn-more {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-learn-more:hover {
            background: #f8f9fa;
        }
        
        .promo-image {
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            max-width: 200px;
        }
        
        .btn-close-promo {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: #6c757d;
            cursor: pointer;
        }
        
        .search-filter-bar {
            background: white;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .search-bar {
            position: relative;
            max-width: 280px;
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
        }
        
        .filter-btn:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .sort-dropdown {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: #212529;
            font-weight: 400;
        }
        
        .sort-dropdown:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .clients-table {
            background: white;
        }
        
        .clients-table thead th {
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .clients-table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .clients-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #c4b5fd 0%, #ddd6fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5b21b6;
            font-weight: 600;
            font-size: 1rem;
            margin-right: 0.75rem;
        }
        
        .client-info {
            display: flex;
            align-items: center;
        }
        
        .client-details {
            display: flex;
            flex-direction: column;
        }
        
        .client-name {
            font-weight: 500;
            color: #212529;
            margin-bottom: 0.125rem;
        }
        
        .client-email {
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .sort-icon {
            margin-left: 0.25rem;
            font-size: 0.75rem;
        }
        
        .rating-badge {
            background: white;
            border: 1px solid #fbbf24;
            border-radius: 20px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            color: #f59e0b;
            font-weight: 600;
        }
        
        .promo-rating {
            position: absolute;
            right: 2.5rem;
            top: 2rem;
            background: white;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            font-weight: 600;
        }
        
        .promo-rating .stars {
            color: #f59e0b;
            font-size: 0.875rem;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Client List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Client List</li>
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
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h1 class="page-title">
                        Clients list
                        <span class="badge">3</span>
                    </h1>
                    <p class="page-subtitle">View, add, edit and delete your client's details. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-options dropdown-toggle">
                        Options
                    </button>
                    <button class="btn btn-add">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Promotional Banner -->
        <div class="promo-banner">
            <button class="btn-close-promo">×</button>
            <div class="promo-content">
                <h2 class="promo-title">Set up your Fresha profile for clients to book online</h2>
                <p class="promo-description">Free up time and get your clients self-booking online 24/7.</p>
                <button class="btn btn-learn-more">
                    Learn more
                </button>
            </div>
            <div class="promo-rating">
                <span class="stars">? 5.0</span>
                <div style="font-size: 0.75rem; color: #6c757d;">Top rated</div>
            </div>
            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='%233b82f6'/%3E%3Ccircle cx='100' cy='80' r='30' fill='%23f0abfc'/%3E%3Crect x='70' y='110' width='60' height='70' rx='5' fill='%236366f1'/%3E%3Ctext x='100' y='190' font-family='Arial' font-size='10' fill='white' text-anchor='middle'%3E5? Excellent (180+)%3C/text%3E%3C/svg%3E" alt="Fresha Profile" class="promo-image">
        </div>

        <!-- Search and Filters -->
        <div class="search-filter-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="search-bar">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Name, email or phone">
                    </div>
                    <button class="filter-btn">
                        <i class="bi bi-funnel"></i>
                        Filters
                    </button>
                </div>
                <button class="sort-dropdown dropdown-toggle">
                    Created at (newest first)
                </button>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="table-responsive">
            <table class="table clients-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input">
                        </th>
                        <th>Client name</th>
                        <th>Mobile number</th>
                        <th>Reviews</th>
                        <th>Sales</th>
                        <th>
                            Created at
                            <i class="bi bi-arrow-down sort-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="client-info">
                                <div class="client-avatar">J</div>
                                <div class="client-details">
                                    <div class="client-name">Jack Doe</div>
                                    <div class="client-email">jack@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted">-</span></td>
                        <td><span class="text-muted">-</span></td>
                        <td>?0</td>
                        <td>15 Nov 2025</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="client-info">
                                <div class="client-avatar">J</div>
                                <div class="client-details">
                                    <div class="client-name">Jane Doe</div>
                                    <div class="client-email">jane@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted">-</span></td>
                        <td><span class="text-muted">-</span></td>
                        <td>?0</td>
                        <td>15 Nov 2025</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td>
                            <div class="client-info">
                                <div class="client-avatar">J</div>
                                <div class="client-details">
                                    <div class="client-name">John Doe</div>
                                    <div class="client-email">john@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="text-muted">-</span></td>
                        <td><span class="text-muted">-</span></td>
                        <td>?0</td>
                        <td>15 Nov 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
 <script>
        // Close promo banner
        document.querySelector('.btn-close-promo').addEventListener('click', function() {
            document.querySelector('.promo-banner').style.display = 'none';
        });
    </script>

@endsection