@extends('store.layouts.app')

@section('title', 'Sales List')

@section('content')
<style>
      
        
        .page-header {
            background: white;
            padding: 2rem 0 1rem;
            margin-bottom: 0;
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
        
        .btn-add-new {
            background: #000;
            border: 1px solid #000;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-add-new:hover {
            background: #212529;
            border-color: #212529;
            color: white;
        }
        
        .tabs-container {
            background: white;
            padding: 0 0 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .nav-pills-custom {
            gap: 0.5rem;
        }
        
        .nav-pills-custom .nav-link {
            background: transparent;
            color: #6c757d;
            border-radius: 20px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            border: none;
        }
        
        .nav-pills-custom .nav-link.active {
            background: #000;
            color: white;
        }
        
        .nav-pills-custom .nav-link:hover:not(.active) {
            background: #f8f9fa;
            color: #212529;
        }
        
        .search-filter-bar {
            background: white;
            padding: 1rem 0 1.5rem;
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
        
        .empty-state {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 5rem 2rem;
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }
        
        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1.5rem;
        }
        
        .btn-create-sale {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-create-sale:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Sales List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Sales List</li>
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
                <div class="col-md-8">
                    <h1 class="page-title">Sales</h1>
                    <p class="page-subtitle">View, filter and export the history of your sales. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-options dropdown-toggle">
                        Options
                    </button>
                    <button class="btn btn-add-new">
                        Add new
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-container">
        <div class="container-fluid px-4">
            <ul class="nav nav-pills nav-pills-custom">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Drafts</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filter-bar">
        <div class="container-fluid px-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2">
                        <div class="search-bar">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" placeholder="Search by Sale or Client">
                        </div>
                        <button class="filter-btn">
                            <i class="bi bi-calendar3"></i>
                            Today
                        </button>
                        <button class="filter-btn">
                            <i class="bi bi-funnel"></i>
                            Filters
                        </button>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="filter-btn">
                        <i class="bi bi-arrow-down-up"></i>
                        Sort by
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="container-fluid px-4">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <h2 class="empty-title">No sales yet</h2>
            <button class="btn btn-create-sale">
                Create new sale
            </button>
        </div>
    </div>
    </div>
</div>

@endsection