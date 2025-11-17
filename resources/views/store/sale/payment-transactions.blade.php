@extends('store.layouts.app')

@section('title', 'Payment Transaction List')

@section('content')
 <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .page-header {
            background: white;
            padding: 2rem 0 1.5rem;
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
            margin-bottom: 0;
        }
        
        .btn-options {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-options:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .search-filter-bar {
            background: white;
            padding: 1.5rem 0 1.5rem;
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
        
        .date-range-btn {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: #212529;
            font-weight: 400;
            min-width: 240px;
            text-align: left;
        }
        
        .date-range-btn:hover {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
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
            padding: 6rem 2rem;
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .empty-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }
        
        .empty-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .empty-description {
            color: #6c757d;
            font-size: 0.95rem;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Payment Transaction List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Payment Transaction List</li>
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
                <div class="col-md-10">
                    <h1 class="page-title">Payment transactions</h1>
                    <p class="page-subtitle">View, filter and export the history of your payments.</p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-options dropdown-toggle">
                        Options
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filter-bar">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="search-bar">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control" placeholder="Search by Sale or Client">
                </div>
                <button class="date-range-btn dropdown-toggle d-flex justify-content-between align-items-center">
                    <span>Oct 18, 2025 - Nov 17, 2025</span>
                    <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <button class="filter-btn">
                    <i class="bi bi-funnel"></i>
                    Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="container-fluid px-4">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h2 class="empty-title">No results found</h2>
            <p class="empty-description">Try adjusting your search and filters.</p>
        </div>
    </div>

    </div>
</div>

@endsection