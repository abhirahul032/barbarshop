@extends('store.layouts.app')

@section('title', 'Orders')

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
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .page-title .badge {
            font-size: 1rem;
            font-weight: 400;
            background: transparent;
            color: #6c757d;
            padding: 0;
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
        }
        
        .btn-options:hover {
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
            background: linear-gradient(135deg, #c084fc 0%, #8b5cf6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
            position: relative;
        }
        
        .empty-icon::after {
            content: '';
            position: absolute;
            right: -4px;
            top: 50%;
            transform: translateY(-50%);
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            border-radius: 0 12px 12px 0;
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
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Orders</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                    <li class="breadcrumb-item active">Orders</li>
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
                    <h1 class="page-title">
                        Stock orders
                        <span class="badge">0</span>
                    </h1>
                    <p class="page-subtitle">Add and manage your stock orders. <a href="#">Learn more</a></p>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-options dropdown-toggle">
                        Options
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="container-fluid px-4">
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-box-seam"></i>
            </div>
            <h2 class="empty-title">No products created yet</h2>
            <p class="empty-description">Add products in minutes and start creating stock orders.</p>
            <button class="btn btn-learn-more">
                Learn more
            </button>
        </div>
    </div>
    </div>
</div>

@endsection