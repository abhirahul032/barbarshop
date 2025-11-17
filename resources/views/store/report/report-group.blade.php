@extends('store.layouts.app')

@section('title', 'Report Group')

@section('content')
 <style>
        
        
        .reports-layout {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid #e5e7eb;
            padding: 2rem 0;
            flex-shrink: 0;
        }
        
        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            padding: 0 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
        }
        
        .sidebar-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem;
            color: #374151;
            cursor: pointer;
            font-size: 0.95rem;
        }
        
        .sidebar-item:hover {
            background: #f9fafb;
        }
        
        .sidebar-item.active {
            background: #f3f4f6;
            color: #212529;
            font-weight: 500;
        }
        
        .sidebar-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-icon {
            font-size: 1.125rem;
            color: #6b7280;
        }
        
        .sidebar-count {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.125rem 0.5rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .sidebar-section {
            padding: 0 1.5rem;
            margin-top: 2rem;
        }
        
        .sidebar-section-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .add-folder-btn {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .add-folder-btn:hover {
            text-decoration: underline;
        }
        
        .data-connector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 8px;
            margin-top: 1rem;
        }
        
        .connector-icon {
            width: 32px;
            height: 32px;
            background: #22c55e;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .connector-label {
            color: #212529;
            font-size: 0.95rem;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        
        .content-title-section {
            flex: 1;
        }
        
        .content-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .title-count {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.625rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .content-description {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .content-description a {
            color: #6366f1;
            text-decoration: none;
        }
        
        .content-description a:hover {
            text-decoration: underline;
        }
        
        .btn-add {
            background: #212529;
            color: white;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .btn-add:hover {
            background: #000;
            color: white;
        }
        
        .search-filter-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .search-box {
            position: relative;
            flex: 1;
        }
        
        .search-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 0.95rem;
            background: white;
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
        
        .filter-buttons {
            display: flex;
            gap: 0.75rem;
        }
        
        .btn-filter {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-filter:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .category-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .category-tab {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: none;
            background: white;
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
        }
        
        .category-tab:hover {
            background: #f9fafb;
        }
        
        .category-tab.active {
            background: #212529;
            color: white;
        }
        
        .reports-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .report-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            cursor: pointer;
        }
        
        .report-item:hover {
            border-color: #d1d5db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .report-icon {
            width: 48px;
            height: 48px;
            background: #f0fdf4;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .report-icon i {
            color: #22c55e;
            font-size: 1.25rem;
        }
        
        .report-content {
            flex: 1;
        }
        
        .report-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }
        
        .report-description {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .report-badges {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .premium-badge {
            background: #ede9fe;
            color: #7c3aed;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .star-icon {
            color: #d1d5db;
            font-size: 1.25rem;
            cursor: pointer;
        }
        
        .star-icon:hover {
            color: #fbbf24;
        }
        
        @media (max-width: 992px) {
            .reports-layout {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Report Group</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Report Group</li>
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
        <div class="reports-layout">
        <aside class="sidebar">
            <h2 class="sidebar-title">Reports</h2>
            
            <ul class="sidebar-menu">
                <li class="sidebar-item active">
                    <div class="sidebar-item-left">
                        <i class="bi bi-list-ul sidebar-icon"></i>
                        <span>All reports</span>
                    </div>
                    <span class="sidebar-count">52</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-star sidebar-icon"></i>
                        <span>Favourites</span>
                    </div>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-graph-up sidebar-icon"></i>
                        <span>Dashboards</span>
                    </div>
                    <span class="sidebar-count">2</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-grid-3x3 sidebar-icon"></i>
                        <span>Standard</span>
                    </div>
                    <span class="sidebar-count">44</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-gem sidebar-icon"></i>
                        <span>Premium</span>
                    </div>
                    <span class="sidebar-count">8</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-bullseye sidebar-icon"></i>
                        <span>Custom</span>
                    </div>
                    <span class="sidebar-count">0</span>
                </li>
                <li class="sidebar-item">
                    <div class="sidebar-item-left">
                        <i class="bi bi-crosshair sidebar-icon"></i>
                        <span>Targets</span>
                    </div>
                </li>
            </ul>

            <div class="sidebar-section">
                <h3 class="sidebar-section-title">Folders</h3>
                <a href="#" class="add-folder-btn">
                    <i class="bi bi-plus-lg"></i>
                    Add folder
                </a>

                <div class="data-connector">
                    <div class="connector-icon">
                        <i class="bi bi-database"></i>
                    </div>
                    <span class="connector-label">Data connector</span>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <div class="content-title-section">
                    <h1 class="content-title">
                        Reporting and analytics
                        <span class="title-count">52</span>
                    </h1>
                    <p class="content-description">
                        Access all of your Fresha reports. <a href="#">Learn more</a>
                    </p>
                </div>
                <button class="btn btn-add">Add</button>
            </div>

            <div class="search-filter-section">
                <div class="search-box">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by report name or description">
                </div>
                <div class="filter-buttons">
                    <button class="btn btn-filter">
                        Created by
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <button class="btn btn-filter">
                        Category
                        <i class="bi bi-sliders"></i>
                    </button>
                </div>
            </div>

            <div class="category-tabs">
                <button class="category-tab active">All reports</button>
                <button class="category-tab">Sales</button>
                <button class="category-tab">Finance</button>
                <button class="category-tab">Appointments</button>
                <button class="category-tab">Team</button>
                <button class="category-tab">Clients</button>
                <button class="category-tab">Inventory</button>
            </div>

            <div class="reports-list">
                <div class="report-item">
                    <div class="report-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-title">Performance dashboard</div>
                        <div class="report-description">Dashboard of your business performance.</div>
                    </div>
                    <div class="report-badges">
                        <i class="bi bi-star star-icon"></i>
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-title">Online presence dashboard</div>
                        <div class="report-description">Online sales and online client performance</div>
                    </div>
                    <div class="report-badges">
                        <i class="bi bi-star star-icon"></i>
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-title">Performance summary</div>
                        <div class="report-description">Overview of business performance by team or location</div>
                    </div>
                    <div class="report-badges">
                        <span class="premium-badge">Premium</span>
                        <i class="bi bi-star star-icon"></i>
                    </div>
                </div>

                <div class="report-item">
                    <div class="report-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="report-content">
                        <div class="report-title">Performance over time</div>
                        <div class="report-description">View of key business metrics by Location or Team Member over time</div>
                    </div>
                    <div class="report-badges">
                        <span class="premium-badge">Premium</span>
                        <i class="bi bi-star star-icon"></i>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </div>
</div>

@endsection